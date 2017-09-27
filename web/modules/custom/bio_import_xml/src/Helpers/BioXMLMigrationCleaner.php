<?php

namespace Drupal\bio_import_xml\Helpers;

class BioXMLMigrationCleaner {

    public static function clean($pathToXml) {
        $xmlFile  = $pathToXml . 'xml/Weekly_HM_Bios.xml';
        $cleanXml = $pathToXml . 'xml/Weekly_HM_Bios_fx.xml';

        // load contents of file into memory
        $xmlData  = file_get_contents($xmlFile);
        $handle   = fopen($cleanXml, "w+");

        $outgoing = BioXMLMigrationHelpers::stripInvalidXml($xmlData);
        fwrite($cleanXml, str_replace('<Bio id', "\n" . '<Bio id', $outgoing));
        return fclose($cleanXml);
    }
}