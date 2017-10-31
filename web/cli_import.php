#!/usr/local/bin/drush

use Drupal\bio_import_xml\Helpers\BioXMLMigrationImporter;

$db =  \Drupal::database();
$cfg = \Drupal::config('bio_import_xml');
$log = \Drupal::logger('bio_import_xml');

echo "it didn't blow up!\nyay!\n";

$recordset = BioXMLMigrationImporter::import($db, $cfg, \Drupal::logger('bio_import_xml'));

echo "found " . count($recordset) . " records.\n";
