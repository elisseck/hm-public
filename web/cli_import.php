<?php

use Drupal\bio_import_xml\Helpers;
use Drupal\Core\Database\Connection;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigBase;
use Psr\Log\LoggerInterface;

const MODULE_NAME = 'bio_import_xml';
const CONFIG_ID =  MODULE_NAME . '.settings';

$db =  \Drupal::database();
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
  }

  $cfg->save();

  return $cfg;
}


/**
 * Wrapper for the Importer's "clean" method.
 * @param ConfigBase $config
 */
function clean($config) {
  $cleaned = Helpers\BioXMLMigrationCleaner::clean($config);

  if ($cleaned) {
    drupal_set_message(t('XML Document has been cleaned.'), 'status');
  } else {
    drupal_set_message('An error occurred. Please check the error logs.', 'error');
  }
}

/**
 * Wrapper for the Importer's "ingest" method.
 * @param Connection $database
 * @param ConfigBase $config
 */
function ingest($database, $config) {
  if ($config->get(MODULE_NAME . '.rebuild_ingestion_table')) {
    drupal_set_message('all records will be marked new.');
  } else {;
    drupal_set_message('only records changed since last import will be imported');
  }

  Helpers\BioXMLMigrationIngestor::ingest($database, $config, true);
}

/**
 * Wrapper for the Importer's "import" method.
 * @param Connection $database
 * @param ConfigBase $config
 * @param LoggerInterface $logger
 */
function import($database, $config, $logger) {
  Helpers\BioXMLMigrationImporter::import($database, $config, $logger);
}

/**
 * Help text.  Probably not very useful as the 'help' option is under drush
 * control.
 */
function help() {
  drupal_set_message('it was written. . .');
}

/**
 * Script executor.
 *
 * @param Connection $database
 * @param ConfigFactoryInterface $config
 * @param LoggerInterface $logger
 */
function run($database, $config, $logger) {
  drupal_set_message('preparing configuration');
  /** @var ConfigBase $cfg */
  $cfg = loadArgs($config);
  drupal_set_message('executing sanitizing phase. . .');
  clean($cfg);
  drupal_set_message('executing ingestion phase. . .');
  ingest($database, $cfg);
  drupal_set_message('executing import');
  import($database, $cfg, $logger);
}

if (drush_get_option('info')) {
  help();
} else {
  run($db, $cfg, $log);
}
