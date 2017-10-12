<?php
namespace Drupal\bio_import_xml\Helpers;

use Drupal\Core\Database\Connection;
use Drupal\Core\Config\ConfigBase;
use Drupal\node\Entity\Node;
use Drupal\Component\Utility\Unicode;

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

    protected $pdfFields = ['interviewpdf1', 'interviewpdf2'];

  /**
   * @var Node $node
   */
    protected $node = null;

    /**
     * Retrieves a set biographies from the migration table.
     *
     * @param Connection $db
     * @return mixed
     */
    protected function getNewBios(Connection $db, $limit = null) {
      $stmt = "SELECT * FROM {$this->storageTable} WHERE new = :new";

      if ($limit) $stmt .= " LIMIT $limit";

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
            if (!empty($file->getSize())) {
                $output = $file;
            }
        }

        return $output;
    }

    protected function populateSingleValueFields($record) {
        foreach ($this->singleValueFields as $field => $value) {

          if (strlen(trim($record->$value)) && !empty($record->$value)) {
            $truncateMig = Unicode::truncate(
                $record->$value, 240, true, true,
                1
            );
            $this->node->set($field, $record->$value);
          }
        }
        return $this;
    }

    protected function checkPlain($text) {
      return \htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    protected function populateMultiValueFields($record) {
      foreach ($this->multiValueFields as $field => $value) {
        if (strlen(trim($record->$value)) && !empty($record->$value)) {
          $dollarValues = BioXMLMigrationHelpers::migrateThmExplode(
            '$', $record->$value);

          foreach ($dollarValues as $val) {
            $this->node->$field->appendItem($val);
          }
        }
      }
        return $this;
    }

    protected function populateLinkFields($record) {
      foreach ($this->linkFields as $field => $value) {
        if (strlen(trim($record->value)) && !empty($record->value)) {
          $this->node->$field->url = $record->$value;
        }
      }
        return $this;
    }

    protected function populateImageFields($record) {
      foreach($this->imageFields as $field => $value) {

        $imageField = BioXMLMigrationHelpers::attachImage(
          $this->db, $this->config, $record->$value);

        if (($imageField) && !empty($imageField->getSize())) {
          $this->node->$field->appendItem($imageField);
        }
      }

      return $this;
    }

    protected function populatePdfFields($record) {
      foreach ($this->pdfFields as $iPdf) {
        if ($f = $this->imageExists($record, $iPdf)) {
          $record->$iPdf->appendItem($f);
        } else {
            \drupal_set_message('no pdf.');
        }
      }

      return $this;
    }

    protected function populateTaxonomyFields($record) {
      foreach ($this->taxonomyFields as $v) {
        $vocab = $v[0];
        $value = $v[1];
        $field = $v[2];

        if (strlen(trim($record->$value))) {

          $tags = BioXMLMigrationHelpers::getTags($record->$value, $vocab);

          if (count($tags)) {
            $this->node->set($field, $tags);
          }
        }
      }
      return $this;
    }

    protected function createOrLoadNode($record) {
      if ($this->nidExists($record->nid)) {
        $this->node = $this->loadExistingNode($record);
      } else {
        //$this->newNodes[] = $record->hm_id;
        $this->node = Node::create([ 'type' => 'bio' ]);
        $this->node->setOwnerId($this->importXmlUser);
      }

      return $this;
    }

    protected function setTitleAndBody($record) {
      $title = $this->node->getTitle();

      if (!isset($title)) {
        $this->node->setTitle(\stripslashes($record->namefirst . ' ' . $record->namelast));
      }

      if (strlen(trim($record->preferredname))) {
        $this->node->setTitle(\stripslashes($record->preferredname));
      }

      $cleanBody = preg_replace(
        '/\xEF\x83\xA2/', '&reg;', $record->biographylong);
      $this->node->get('body')->value = $this->checkPlain($cleanBody);
      $this->node->get('body')->format = 'restricted_html';

      return $this;
    }

    protected function saveNode(){
        try {
            $this->node->save();
        } catch (\Exception $exc) {
            \drupal_set_message(
                'node save for ' . $this->node->get('hm_id')->value . 'failed');
            return false;
        }
        return $this;
    }

    protected function processRecords($recordSet) {
        foreach ($recordSet as $record) {

            /*if (empty($node->get('last_comment_uid'))) {
                $node->set('last_comment_uid', 1);
            }*/

            /*foreach($this->imageFields as $field => $mig) {
                $imageField = BioXMLMigrationHelpers::attachImage($this->db, $mig);
                if ($imageField) {
                    if ($imageField['filesize'] != 0) {
                        $node->$field->value = $imageField;
                    }
                }
            }*/

            /*foreach ($this->taxonomyFields as $v) {
                $vocab = $v[0];
                $mig   = $v[1];
                $field = $v[2];

                if (strlen(trim($record->mig))) {
                    $tags = BioXMLMigrationHelpers::getTags($record->mig, $vocab);

                    if (count($tags)) {
                        $node->$field->value = $tags;
                    }
                }
            }*/

            /*$node->field_bio_pdf = [];
            foreach (['interviewpdf1', 'interviewpdf2'] as $iPdf) {
                if ($f = $this->imageExists($record, $iPdf)) {
                    $node->field_bio_pdf->appendItem($f);
                }
            }*/
        }
    }

    protected function __construct(Connection $db, ConfigBase $config) {
        $this->db = $db;
        $this->config = $config;
    }

    public static function debugPrint(BioXMLMigrationImporter $q) {
      $node = $q->node;

      \drupal_set_message('title: ' . $node->getTitle());
      \drupal_set_message('body: ' . $node->get('body')->value);

      foreach($q->singleValueFields as $field => $value) {
        \drupal_set_message(
          'single val field: ' . $field . ':' .
          $node->get($field)->value);
      }

      foreach($q->linkFields as $field => $value) {
        \drupal_set_message(
          'link val field: ' . $field . ':' .
          $node->get($field)->getValue()[0]['url']);
      }

      foreach ($q->multiValueFields as $field => $value) {
        \drupal_set_message(
          'multi-value field: ' . $field . ':' .
          print_r($node->get($field)->getValue(), true));
      }

        /*foreach ($q->pdfFields as $field) {
            \drupal_set_message(
                'PDF field: ' . $field . ':' .
                print_r($node->get($field)->getValue(), true));
        }*/

      foreach ($q->imageFields as $field => $value) {
        \drupal_set_message(
          'image field: ' . $field . ':' .
          print_r($node->get($field)->getValue(), true));
      }

      /*foreach ($q->taxonomyFields as $field) {

      }*/
    }

    public static function import(Connection $db, ConfigBase $config) {

        $instance = new self($db, $config);

        $rs = $instance->getNewBios($instance->db, 1);

        foreach ($rs as $rec) {
          $instance->createOrLoadNode($rec)
                  ->setTitleAndBody($rec)
                  ->populateSingleValueFields($rec)
                  ->populateLinkFields($rec)
                  ->populateMultiValueFields($rec)
                  ->populateTaxonomyFields($rec)
                  ->populatePdfFields($rec)
                  ->populateImageFields($rec)
                  ->saveNode();

          self::debugPrint($instance);
        }

        //$instance->processRecords($rs);
    }
}