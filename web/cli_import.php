<?php

use Drupal\bio_import_xml\Helpers;

const MODULE_NAME = 'bio_import_xml';
const CONFIG_ID =  MODULE_NAME . '.settings';

$db =  \Drupal::database();
$cfg = \Drupal::service('config.factory');
$log = \Drupal::logger(MODULE_NAME);

/**
 * Loads command-line arguments into a Drupal configuration object
 *
 * @param $config \Drupal\Core\Config\ConfigFactory
 *
 * @return \Drupal\Core\Config\ConfigFactoryInterface
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
  }

  $cfg->save();

  return $cfg;
}

function clean($config) {
  $cleaned = Helpers\BioXMLMigrationCleaner::clean($config);

  if ($cleaned) {
    drupal_set_message(t('XML Document has been cleaned.'), 'status');
  } else {
    drupal_set_message('An error occurred. Please check the error logs.', 'error');
  }
}

function ingest($database, $config) {
  if ($config->get(MODULE_NAME . '.rebuild_ingestion_table')) {
    drupal_set_message('all records will be marked new.', 'status');
    Helpers\BioXMLMigrationIngestor::ingest($database, $config, true);
  }
}

function import($database, $config, $logger) {
  Helpers\BioXMLMigrationImporter::import($database, $config, $logger);
}

function help() {
  drupal_set_message('it was written. . .');
}

function run($database, $config, $logger) {
  drupal_set_message('preparing configuration');
  $config = loadArgs($config);
  drupal_set_message('executing sanitizing phase. . .');
  clean($config);
  drupal_set_message('executing ingestion phase. . .');
  ingest($database, $config);
  drupal_set_message('executing import');
  import($database, $config, $logger);
}

if (drush_get_option('info')) {
  help();
} else {
  run($db, $cfg, $log);
}
