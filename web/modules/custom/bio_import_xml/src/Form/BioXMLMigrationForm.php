<?php
/**
 * @file
 * Administrative form for migrating Biographies from Filemaker to Drupal.
 */
namespace Drupal\bio_import_xml\Form;

use Drupal\Core\Ajax;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\bio_import_xml\Helpers;
use React\EventLoop\Factory;
use React\ChildProcess\Process;
use Drupal\Core\Render\Element\Form;

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

  protected function getNewBios(Connection $db, $limit = 0) {
    return $db->select($this->storageTable, 'mts')
      ->fields('mts')
      ->condition('mts.new', '1')
      ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit($limit)
      ->execute()
      ->fetchAll();
  }

  protected function determinePriority($field) {
    $hiPriority = [ 'hm_id', 'preferredname', ];

    $medPriority = [
      'descriptionshort',
      'dates_of_sessions',
      'category',
      'occupation',
      'gender',
      'maritalstatus'
    ];

    if (in_array($field, $medPriority)) return [RESPONSIVE_PRIORITY_MEDIUM];
    else if (in_array($field, $hiPriority)) return '';
    else return [RESPONSIVE_PRIORITY_LOW];
  }

  protected function buildResponsiveTableHeader($fieldNames) {
    $header = [];

    foreach ($fieldNames as $fieldName) {
      $fn = strtolower($fieldName);

      $header[$fn] = [
        'data' => t($fieldName),
        'class' => $this->determinePriority($fn)
      ];
    }

    return $header;
  }

  public function renderNewBiosGrid() {

    $fieldNames = Helpers\BioXMLMigrationHelpers::$storageFieldNames;

    $fieldNamesAsArray = explode(', ', $fieldNames);

    $header = $this->buildResponsiveTableHeader($fieldNamesAsArray);

    $table = [
      '#type' => 'table',
      '#header' => $header,
      '#empty' => t('No new biographies found.'),
      '#attributes' => [
        'style' => 'display: block; max-width: 100%; overflow-x: scroll;'
      ]
    ];

    $newBios = $this->getNewBios(\Drupal::database(), 5);

    $i = 0;

    foreach ($newBios as $newBio) {

      foreach ($fieldNamesAsArray as $fieldName) {
        $f = strtolower($fieldName);
        $v = (isset($newBio->$f)) ? $newBio->$f : '';

        $table[$i][$f] = [
          '#type' => 'item',
          '#title' => (!empty($v)) ? $this->trimTo40Chars($v) : '',
        ];
      }
      $i++;
    }

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

    $form[$formId]['notice'] = [
      '#markup' => <<<NOTICE
        <div class="alert alert-info">
          <p>Biography imports are no longer performed using this page, but the settings for the process <strong>are</strong> configured here.</p>
          <p>Please use the commmand-line script for this operation if necessary to run ad-hoc.</p>
          <p>The current cron job is run per the crontab settings for the devwww user.</p>
          <p>To see the current cron settings, run <code>crontab -l</code> as the devwww user on the server.</p>
        </div>
NOTICE
    ];

    $form[$formId]['reset_flag'] = [
      '#type' => 'hidden',
      '#value' => $reset,
    ];

    $form[$formId]['fm_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Absolute path to the XML file. (with trailing slash!)'),
      '#default_value' => $config->get('bio_import_xml.fm_path'),
    ];

    $form[$formId]['fm_files_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Absolute path to accompanying media. (with trailing slash!)'),
      '#default_value' => $config->get('bio_import_xml.fm_files_path')
    ];

    $form[$formId]['email_notify'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email to notify once process is complete.'),
      '#default_value' => $config->get('bio_import_xml.notify_email')
    ];

    $form[$formId]['clean_xml'] = [
      '#type' => 'submit',
      '#value' => t('1. Clean feed.'),
      '#submit' => [ '::clean' ],
      '#attributes' => [ 'disabled' => 'disabled' ],
    ];

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

    Helpers\BioXMLMigrationIngestor::ingest(
      \Drupal::database(), $config, $resetFlag);
  }

  /**
   * {@inheritdoc}
   */
  public function import(&$form, FormStateInterface $formState) {

    $loop = Factory::create();

    $drush_exec = '../vendor/bin/drush';

    $process = new Process($drush_exec . ' scr cli_import');

    $process->start($loop);

    $process->stdout->on('data', function($chunk) {
      \drupal_set_message(print_r($chunk, true));
    });

    $process->on('exit', function($exitCode, $termSignal) {
      \drupal_set_message('process exited with ' . $exitCode);
    });

    $loop->run();
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $formState) {
    $values = $formState->getValues();

    // TODO: Test if fm_path is an existing directory. Notify user if doesn't exist.

    $this->configFactory->getEditable('bio_import_xml.settings')
      ->set('bio_import_xml.fm_path', $values['fm_path'])
      ->set('bio_import_xml.fm_files_path', $values['fm_files_path'])
      ->set('bio_import_xml.notify_email', $values['email_notify'])
      ->save();

    parent::submitForm($form, $formState);
  }
}
