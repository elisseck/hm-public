<?php

namespace Drupal\bio_import_xml\Helpers;

use Drupal\Core\Config\ConfigBase;

/**
 * Class BioXMLMigrationCleaner
 * @package Drupal\bio_import_xml\Helpers
 */
class BioXMLMigrationCleaner {

    /**
     * @var string $module The name of the module.
     */
    public static $module = 'bio_import_xml';

    /**
     * Removes illegal characters from an XML Document.
     *
     * Creates a new "cleaned" XML Document with illegal characters removed.
     *
     * @param $config ConfigBase
     * @return bool
     */
    public static function clean(ConfigBase $config) {
        $module = self::$module;
        $pathToXml = $config->get($module . '.fm_path');
        $xmlFile   = $pathToXml . $config->get($module . '.original');
        $cleanXml  = $pathToXml . $config->get($module . '.clean');

        $xmlData  = file_get_contents($xmlFile);

        if ($xmlData === FALSE) {
            \drupal_set_message("file: $xmlFile not found.");
            return FALSE;
        }

        $handle   = fopen($cleanXml, "w+");
        $outgoing = BioXMLMigrationHelpers::stripInvalidXml($xmlData);

        fwrite($handle, str_replace('<Bio id', "\n" . '<Bio id', $outgoing));
        return fclose($handle);
    }
}