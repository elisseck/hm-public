<?php
namespace Drupal\bio_import_xml\Helpers;

use Drupal\Core\Database\Connection;
use Drupal\Core\Config\ConfigBase;
use Drupal\node\Entity\Node;

class BioXMLMigrationImporter {


    protected $config;

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

    protected $superUid = 1;

    protected $newNodes = [];

    /**
     * @var int $recordsProcessed
     */
    protected $recordsProcessed = 0;

    protected $singleValueFields = [
        'field_first_name'                => 'namefirst',
        'field_last_name'                 => 'namelast',
        'field_hm_id'                     => 'hm_id',
        'field_accession_number'          => 'accession',
        'field_middle_name'               => 'namemiddle',
        'field_hm_city_state_country'     => 'birthcity',
        'field_sex'                       => 'gender',
        'field_favorite_color'            => 'favorite_color',
        'field_favorite_food'             => 'favorite_food',
        'field_favorite_season'           => 'favorite_season',
        'field_favorite_vacation'         => 'favorite_vacationspot',
        'field_favorite_quote'            => 'favorite_quote',
        'field_description'               => 'descriptionshort',
        'field_speakers_bureau'           => 'speakersbureauyesno',
        'field_state'                     => 'birthstate',
        'field_country'                   => 'birthcountry',
        'field_birth_date'                => 'datebirth',
        'field_sponsor'                   => 'sponsor',
        'field_death_date'                => 'datedeath',
        'field_speakers_bureau_notes'     => 'speakersbureaunotes',
        'field_bureau_region_city'        => 'regioncity',
        'field_bureau_region_state'       => 'regionstate',
        'field_speakers_bureau_audience'  => 'speakersbureaupreferredaudience',
        'field_speakers_bureau_honorarium'=> 'speakersbureauhonorarium',
        'field_speakers_bureau_available' => 'speakersbureauavailability',
        'field_married'                   => 'maritalstatus',
        'field_event_title_sponsor_url'   => 'sponsorurl',
    ];

    protected $linkFields = [
        'field_thm_da_link'           => 'linktothmda',
        'field_sm_da_link'            => 'linktosmda',
    ];

    protected $multiValueFields = [
        'field_flash_video'        => 'location_flash_file',
        'field_flash_video_titles' => 'location_flash_title',
        'field_employment'         => 'employment_for',
        'field_schools'            => 'schools_for',
        'field_interview_date'     => 'dates_of_sessions',
    ];

    protected $imageFields = [
        'field_bio_image'           => 'imagebio',
        'field_archival_image1'     => 'imagearchive01',
        'field_archival_image2'     => 'imagearchive02',
        'field_event_title_sponsor' => 'sponsorlogo',
    ];

    protected $taxonomyFields = [
        ['tags', 'biographylongwords',  'field_tags'],
        ['maker_category', 'category',  'field_maker_category'],
        ['birth_place', 'birthcity',    'field_birth_place_term'],
        ['occupation', 'occupation',    'field_occupation'],
        ['occupation_categories', 'occupationcategories',  'field_search_occupation_category'],
        ['organizations', 'organizations', 'field_organizations'],
    ];

    /**
     * Retrieves a set biographies from ingest table.
     *
     * @param Connection $db
     * @return mixed
     */
    protected function getNewBios(Connection $db) {
        $stmt = "SELECT * FROM {$this->storageTable} WHERE new = :new";
        return $db->query($stmt, [':new' => '1'])->fetchAll();
    }

    protected function nidExists($value) {
        return strlen(trim($value));
    }

    protected function noUserForNode($uid) {
        return (intval($uid) == 0 || empty($uid));
    }

    protected function loadExistingNode($record) {
        $node = Node::load($record->nid);

        if ($this->noUserForNode($node->id())) $node->setOwnerId($this->superUid);

        $node->setRevisionUserId($this->importXmlUser);
        $node->set('type', 'bio');

        return $node;

    }

    protected function imageExists($record, $fieldName) {
        $output = false;

        if (!isset($record->$fieldName)) {
            $output = false;
        } else {
            $file = BioXMLMigrationHelpers::attachImage(
                $this->db, $this->config, $record->$fieldName);
            if ($file['filesize'] != 0) {
                $output = $file;
            }
        }

        return $output;
    }

    protected function populateSingleValueFields($node, $record) {
        foreach ($this->singleValueFields as $field => $mig) {
            if (strlen(trim($mig)) && !empty($mig)) {
                $truncateMig = truncate_utf8(
                    $record->mig, 240, true, true,
                    1
                );
                $node->$field->value = $mig;
                $node->$field->safe_value = check_plain($truncateMig);
            }
        }
        return $this;
    }

    protected function populateMultiValueFields($node) {
        // TODO: Move and refactor multi-value field loop.
        return $this;
    }

    protected function populateLinkFields($node) {
        // TODO: Move and refactor link field loop.
        return $this;
    }

    protected function populateImageFields($node) {
        // TODO: Move and refactor image field loop.
        return $this;
    }

    protected function populatePdfFields($node) {
        // TODO: Move and refactor PDF field loop.
        return $this;
    }

    protected function processRecords($recordSet) {
        foreach ($recordSet as $record) {

            if ($this->nidExists($record->nid)) {
                $node = $this->loadExistingNode($record);
            } else {
                //$this->newNodes[] = $record->hm_id;
                $node = Node::create([ 'type' => 'bio' ]);
                $node->setOwnerId($this->importXmlUser);
            }

            $title = $node->getTitle();

            if (!isset($title)) {
                $node->setTitle($record->namefirst . ' ' . $record->namelast);
            }

            if (strlen(trim($record->preferredname))) {
                $node->setTitle($record->preferredname);
            }

            $cleanBody = preg_replace(
                '/\xEF\x83\xA2/', '&reg;', $record->biographylong);
            $node->body->value = check_plain($cleanBody);
            $node->body->format = 'filtered_html';

            if (empty($node->get('last_comment_uid'))) {
                $node->set('last_comment_uid', 1);
            }



            foreach ($this->linkFields as $field => $mig) {
                if (strlen(trim($mig)) && !empty($mig)) {
                    $node->$field->url = $mig;
                }
            }

            foreach ($this->multiValueFields as $field => $mig) {
               if (strlen(trim($mig)) && !empty($mig)) {
                   $dollarVals = BioXMLMigrationHelpers::migrateThmExplode(
                       '$', $mig);
                   foreach ($dollarVals as $val) {
                       $node->$field->appendItem($val);
                   }
               }
            }

            foreach($this->imageFields as $field => $mig) {
                $imageField = BioXMLMigrationHelpers::attachImage($this->db, $mig);
                if ($imageField) {
                    if ($imageField['filesize'] != 0) {
                        $node->$field->value = $imageField;
                    }
                }
            }

            foreach ($this->taxonomyFields as $v) {
                $vocab = $v[0];
                $mig   = $v[1];
                $field = $v[2];

                if (strlen(trim($record->mig))) {
                    $tags = BioXMLMigrationHelpers::getTags($record->mig, $vocab);

                    if (count($tags)) {
                        $node->$field->value = $tags;
                    }
                }
            }

            $node->field_bio_pdf = [];
            foreach (['interviewpdf1', 'interviewpdf2'] as $iPdf) {
                if ($f = $this->imageExists($record, $iPdf)) {
                    $node->field_bio_pdf->appendItem($f);
                }
            }
        }
    }

    protected function __construct(Connection $db, ConfigBase $config) {
        $this->db = $db;
        $this->config = $config;
    }

    public static function import(Connection $db, ConfigBase $config) {

        $instance = new self($db, $config);

        $rs = $instance->getNewBios($instance->db);

        $instance->processRecords($rs);
    }
}