<?php
/**
 * @file
 * Administrative form for migrating Biographies from Filemaker to Drupal.
 */
namespace Drupal\bio_import_xml\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\bio_import_xml\Helpers;

/**
 * Class BioXMLMigrationForm
 * @package Drupal\bio_import_xml\Form
 */
class BioXMLMigrationForm extends ConfigFormBase {

    protected $storageTable = 'migrate_thm_storage';

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [ 'bio_import_xml.settings' ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'bio_import_xml_migration_form_settings';
    }

  protected function getNewBios($db, $limit = null) {
    $stmt = "SELECT * FROM {$this->storageTable} WHERE new = :new";

    if ($limit) $stmt .= " LIMIT $limit";

    return $db->query($stmt, [':new' => '1'])->fetchAll();
  }

    public function renderNewBiosGrid() {
      $fieldNames = 'HM_ID, nid, Accession, BirthCity, BirthState, BirthCountry,
       DateBirth, Dates_of_Sessions, DateDeath, MaritalStatus, Gender, 
       Favorite_Color, Favorite_Food, Favorite_Quote, Favorite_Season, 
       Favorite_VacationSpot, PreferredName, NameFirst, NameMiddle, NameLast, 
       BiographyLong, DescriptionShort, Category, Location_Flash_File, 
       Location_Flash_Title, Employment_for, Occupation, OccupationCategories, 
       Organizations, Sponsor, Schools_for, BiographyLongWords, ImageBio, 
       ImageArchive01, ImageArchive02, BiographyLongPath, SpeakersBureauYesNo, 
       SpeakersBureauPreferredAudience, SpeakersBureauHonorarium, 
       SpeakersBureauAvailability, SpeakersBureauNotes, RegionCity, RegionState,
       TimeStampModificationAny, SponsorLogo, SponsorURL, InterviewPDF1, 
       InterviewPDF2, LinkToTHMDA, LinkToSMDA, DAStoryList, DASession, DACaption,
       DAStory, DATape, DATitle, DAUrl, new, timestamp';

      $fieldNamesAsArray = explode(', ', $fieldNames);

      $table = [
        '#type' => 'table',
        '#caption' => $this->t('New Biographies'),
        '#header' => $fieldNamesAsArray,
      ];



      $newBios = $this->getNewBios(\Drupal::database(), 20);

      pager_default_initialize(count($newBios), 5);
      $i = 0;

      foreach ($newBios as $newBio) {

        foreach ($fieldNamesAsArray as $fieldName) {
          $f = strtolower($fieldName);

          $table[$i][$f] = [
            '#type' => 'item',
            '#title' => $this->trimTo40Chars($newBio->$f),
          ];
        }
        $i++;
      }

      $table['pager'] = [
        '#type' => 'pager'
      ];

      return $table;
    }

    public function trimTo40Chars($v) {
      return substr($v, 0, 40);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, $reset = NULL) {
      $formId = 'bio_migrator';
      $config = $this->config('bio_import_xml.settings');

      $form[$formId] = [
          '#type' => 'fieldset',
          '#title' => t('Import Filemaker XML Feed.'),
      ];

      $form[$formId]['reset_flag'] = [
          '#type' => 'hidden',
          '#value' => $reset,
      ];

      $form[$formId]['fm_path'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Absolute path to the XML file.'),
          '#default_value' => $config->get('bio_import_xml.fm_path'),
      ];

      $form[$formId]['clean_xml'] = [
          '#type' => 'submit',
          '#value' => t('1. Clean feed.'),
          '#submit' => [ '::clean' ],
      ];

      $form[$formId]['ingest_xml'] = [
          '#type' => 'submit',
          '#value' => t('2. Validate and store feed records'),
          '#submit' => [ '::ingest' ],
      ];

      $form[$formId]['process_data'] = [
          '#type' => 'submit',
          '#value' => t('3. Import records to website'),
          '#submit' => [ '::import' ],
      ];

      $form[$formId]['table'] = $this->renderNewBiosGrid($form);

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function clean() {
        $config = $this->config('bio_import_xml.settings');

        $cleaned = Helpers\BioXMLMigrationCleaner::clean($config);

        if ($cleaned) {
            \drupal_set_message(t('XML Document has been cleaned.'), 'status');
        } else {
          \drupal_set_message(
            'something went wrong. please check the error logs.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function ingest(array &$form, FormStateInterface $formState) {
        $config = $this->config('bio_import_xml.settings');
        $values = $formState->getValues();
        $reset = $values['reset_flag'];
        $resetFlag = false;

        if ($reset == 'reset') {
            \drupal_set_message('all records will be marked new.', 'status');
            $resetFlag = true;
        }

        Helpers\BioXMLMigrationIngestor::ingest(\Drupal::database(), $config, $resetFlag);
    }

    /**
     * {@inheritdoc}
     */
    public function import() {
      $config = $this->config('bio_import_xml.settings');

      Helpers\BioXMLMigrationImporter::import(
        \Drupal::database(), $config, \Drupal::logger('bio_import_xml'));
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $formState) {
        $values = $formState->getValues();

        // TODO: Test if fm_path is an existing directory. Notify user if doesn't exist.

        $this->configFactory->getEditable('bio_import_xml.settings')
            ->set('bio_import_xml.fm_path', $values['fm_path'])
            ->save();

        parent::submitForm($form, $formState);
    }
}