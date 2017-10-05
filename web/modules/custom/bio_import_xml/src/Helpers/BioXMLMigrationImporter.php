<?php
namespace Drupal\bio_import_xml\Helpers;

use Drupal\Core\Database\Connection;
use Drupal\node\Entity\Node;

class BioXMLMigrationImporter {


    /**
     * @var Connection $db Database connection reference.
     */
    protected $db;

    /**
     * @var string $storageTable The name of the source data table.
     */
    protected $storageTable = 'migrate_thm_storage';

    /**
     * @var int $importXmlUser The user id used to load/update Drupal nodes.
     */
    protected $importXmlUser = 155;

    /**
     * Retrieves a set biographies from ingest table.
     *
     * @param Connection $db
     * @return mixed
     */
    protected function getNewBios(Connection $db) {
        $stmt = "SELECT * FROM {$this->storageTable} WHERE new = :new";
        return $db->query($stmt, [':new', '1'])->fetchAll();
    }

    /**
     * Predicate function that determines if node ID exists.
     *
     * @param $value
     * @return int
     */
    protected function nodeIdExists($value) {
        return strlen(trim($value));
    }

    protected function noUserForNode($uid) {
        return (intval($uid) == 0 || empty($uid));
    }

    protected function processRecords($recordSet) {
        foreach ($recordSet as $record) {

            $node = Node::load($record->nid);

            if (!$this->nodeExists($node->id())) {
                $node->setOwnerId(1);
                $node->setRevisionUserId($this->importXmlUser);
                $node->set('type', 'bio');
            } else {
                // TODO: Implement node creation logic.
            }
        }
    }

    protected function __construct(Connection $db) {
        $this->db = $db;
    }

    public static function import(Connection $db) {
        $instance = new self($db);

        $rs = $instance->getNewBios($instance->db);

        $instance->processRecords($rs);
    }
}