<?php
namespace Drupal\bio_import_xml\Helpers;

use Drupal\Core\Database\Connection;
use Drupal\Core\Config\ConfigBase;


class BioXMLMigrationIngestor {

    /**
     * @var string $module The name of the module.
     */
    protected $module = 'bio_import_xml';

    /**
     * @var string $storageTable The name of the target table.
     */
    protected $storageTable = 'migrate_thm_storage';

    /**
     * @var bool $reset A flag that marks incoming records as new if true.
     */
    protected $reset;

    /**
     * @var Connection $db A Drupal database connection.
     */
    protected $db;

    /**
     * @var array $data
     */
    protected $data = [
        'to_insert' => [
            'fields' => [], 'values' => []
        ],
        'to_update' => [],
    ];



    public function isAnExistingHistoryMakersID($key, $val) {
        return (is_int($key) && isset($val));
    }

    public function isAValidHistoryMakersID($val) {
        return strlen($val) > 5;
    }

    public function isAValidAccessionNumber($val) {
        return strlen($val) > 8;
    }

    public function isDateLessThanAWeekOld($val) {
        return (time() - $val) < (86400 * 7);
    }

    public function getNidFromHmidDataField(Connection $db, $hmId) {
        $stmt = "SELECT entity_id FROM {field_data_field_hm_id} hmid INNER JOIN
        node n on (hmid.entity_id = n.nid) WHERE field_hm_id_value = :hm_id";

        return $db->query($stmt, [':hm_id', $hmId])->fetchField();
    }

    public function prepareTable() {
        $schema = $this->db->schema();

        if (!$schema->fieldExists($this->storageTable, 'location_flash_title')) {
            $schema->dropTable($this->storageTable);
            \drupal_set_message("Flushing table: $this->storageTable");
        }

        if (!$schema->tableExists($this->storageTable)) {
            \drupal_set_message("Table: $this->storageTable not found. Creating.");
            \drupal_install_schema('bio_import_xml');
        }

        return ($schema->fieldExists($this->storageTable, 'location_flash_title') &&
                $schema->tableExists($this->storageTable));
    }

    public function loadXml(ConfigBase $config) {
        $module = $this->module;
        $pathToXml = $config->get($module . '.fm_path');
        $xmlFile = $pathToXml . $config->get($module . '.clean');

        return file_get_contents($xmlFile);
    }

    public function convertXml2Array(ConfigBase $config) {
        $xmlData = $this->loadXml($config);

        \drupal_set_message('didn\'t blow up!  yay!');
        /*if ($xmlData === false) {
            \drupal_set_message('The XML data could not be loaded.');
            return false;
        } else {
            return BioXMLMigrationHelpers::xml2array($xmlData);
        }*/
    }

    /**
     * Converts a datetime string into a unix timestamp.
     *
     * @param string $dtValue A string formatted DateTime value.
     * @return false|int A UNIX timestamp.
     */
    public function convertTimeStamp($dtValue) {
        $date = array_shift(explode(' ', $dtValue));
        $dateParts = explode('/', $date);

        return mktime(
            0, 0, 0,
            intval($dateParts[0]), intval($dateParts[1]), intval($dateParts[2]));
    }

    public function processBiography($bio) {
        $done = '';

        foreach ($bio as $field => $value) {
            if ($field === 'SponsorLogo' && is_string($value)) {
                if (substr($value, 0, 5) === 'size:') {
                    $spl = explode('imagewin:', $value);
                    $value = 'imagewin:' . $spl[1];
                }
            }

            if (strpos($done, $field) === false) {
                if (is_array($value)) {
                    $newValue = $value;
                    unset($value);
                    $value = implode(' -$- ', $newValue);
                }
                if (strlen(trim($value))) {
                    $this->data['to_insert']['fields'][] = strtolower($field);
                    $this->data['to_insert']['values'][] = addslashes(urldecode($value));
                    $this->data['to_update'][] =
                        strtolower($field) . " = '" . addslashes(urldecode($value));
                }
            }

            $done = ' - ' . $field;
        }
    }

    public function processBiographies($biographies, $logger) {

        foreach ($biographies as $key => $bio) {
            $hmId = $bio['HM_ID'];

            if (!$this->isAValidHistoryMakersID($bio['HM_ID'])) continue;

            if (!$this->isAValidAccessionNumber($bio['Accession'])) {
                $logger->notice('Skipping ' . $hmId . ' as it has no valid accession number.');
                continue;
            }

            if (isset($bio['TimeStampModificationAny'])) {
                $newDate = $this->convertTimeStamp($bio['TimeStampModificationAny']);

                $this->data['to_insert']['fields'][] = 'timestamp';
                $this->data['to_insert']['values'][] = $newDate;
                $this->data['to_update'][] = "timestamp = '" . $newDate . "' ";
            }

            if ($this->reset) {

                $this->data['to_insert']['fields'][] = 'new';
                $this->data['to_insert']['values'][] = '1';
                $this->data['to_update'][] = "new = '1' ";

                if (!$this->isAnExistingHistoryMakersID($key, $bio['NameFirst'])) {
                    \drupal_set_message('Missing HM fields: ' . $hmId);
                } else {
                    $nid = $this->getNidFromHmidDataField($hmId);

                    $bioCount = BioXMLMigrationHelpers::historyMakerExists($hmId);
                    $action = ($bioCount != 0) ? 'update' : 'insert';

                    if ($nid) {
                        $this->data['to_insert']['fields'][] = 'nid';
                        $this->data['to_insert']['values'][] = $nid;
                        $this->data['to_update'][] = "nid = '" . $nid . "' ";
                    }

                    $this->processBiography($bio);
                    //$this->upsert($action, $hmId, $this->data);
                }
            }
        }
        \drupal_set_message(print_r($this->data, true));
    }

    /*public function upsert($action, $hmId, $data) {
        switch ($action) {
            case 'update':
                $stmt = "UPDATE"
                break;
            case 'insert':
                break;
            default:
                return false;
        }
    }*/

    public function __construct(Connection $db, $reset) {
        $this->db = $db;
        $this->reset = $reset;
    }

    public static function ingest(Connection $db, ConfigBase $config, $reset = false) {
        $instance = new self($db, $reset);

        $instance->prepareTable();
        $bios = $instance->convertXml2Array($config);
        \drupal_set_message(print_r($bios, true));
        //$instance->processBiographies($bios, \Drupal::logger($instance->module));

    }
}