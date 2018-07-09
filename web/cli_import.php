<?php

use Drupal\bio_import_xml\Helpers;
use Drupal\Core\Database\Connection;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigBase;
use Psr\Log\LoggerInterface;

const MODULE_NAME = 'bio_import_xml';
const CONFIG_ID =  MODULE_NAME . '.settings';
const IMAGE_ERROR_STATE = MODULE_NAME . '.image_import_errors';

$db = \Drupal::database();
$cfg = \Drupal::service('config.factory');
$log = \Drupal::logger(MODULE_NAME);

/**
 * Loads command-line arguments into a Drupal configuration object
 *
 * @param $config ConfigFactoryInterface
 *
 * @return ConfigBase
 */
function loadArgs($config) {
  $cfg = $config->getEditable(CONFIG_ID);

  if ($xmlPath = drush_get_option('xml-path')) {
    $cfg->set(MODULE_NAME . '.fm_path', $xmlPath);
  }

  if ($mediaPath = drush_get_option('media-path')) {
    $cfg->set(MODULE_NAME . '.fm_files_path', $mediaPath);
  }

  if ($notify = drush_get_option('notify')) {
    $cfg->set(MODULE_NAME . '.notify_email', $notify);
  }

  if (drush_get_option('reset')) {
    $cfg->set(MODULE_NAME . '.rebuild_ingestion_table', true);
  } else {
    $cfg->set(MODULE_NAME . '.rebuild_ingestion_table', false);
  }

  $cfg->save();

  return $cfg;
}


/**
 * Wrapper for the Importer's `clean` method.
 * @param ConfigBase $config
 */
function clean($config) {
  $cleaned = Helpers\BioXMLMigrationCleaner::clean($config);

  if ($cleaned) {
    drush_print('XML Document has been cleaned.');
  } else {
    drush_print('An error occurred. Please check the error logs.');
  }
}

/**
 * Wrapper for the Importer's `ingest` method.
 * @param Connection $database
 * @param ConfigBase $config
 */
function ingest($database, $config) {
  $reset = $config->get(MODULE_NAME . '.rebuild_ingestion_table') ? true : false;

  if ($reset) {
    drush_print('all records will be marked new.');
  } else {
    drush_print('only records changed since last import will be imported');
  }

  Helpers\BioXMLMigrationIngestor::ingest($database, $config, $reset);
}

/**
 * Wrapper for the Importer's `import` method.
 * @param Connection $database
 * @param ConfigBase $config
 * @param LoggerInterface $logger
 */
function import($database, $config, $logger) {
  Helpers\BioXMLMigrationImporter::import($database, $config, $logger);
}

/**
 * Writes a timestamp.  For use with coordination w/other cron jobs.
 */
function saveTimestamp() {
  \Drupal::state()->set(IMPORT_TIMESTAMP_KEY, date('Y-m-d h:i:s a', time()));
}

/**
 * Help text.  Probably not very useful as the `help` option is under drush
 * control (currently accessible via the `info` option).
 */
function help() {
  drush_print('it was written. . .');
}

/**
 * Script executor.
 *
 * @param Connection $database
 * @param ConfigFactoryInterface $config
 * @param LoggerInterface $logger
 */
function run($database, $config, $logger) {
  drush_print("preparing configuration. . .\n");
  /** @var ConfigBase $cfg */
  $cfg = loadArgs($config);
  \Drupal::state()->set(IMAGE_ERROR_STATE, []);
  //drush_print(print_r($cfg->get()['bio_import_xml']));
  drush_print("executing sanitizing phase. . .\n");
  clean($cfg);
  drush_print("executing ingestion phase. . .\n");
  ingest($database, $cfg);
  drush_print("executing import\n");
  import($database, $cfg, $logger);
  \Drupal::state()->set(IMAGE_ERROR_STATE, []);
}

if (drush_get_option('info')) {
  help();
} else {
  run($db, $cfg, $log);
}
