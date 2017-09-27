<?php

namespace Drupal\bio_import_xml\Helpers;

class BioXMLMigrationHelpers {

    public static function stripInvalidXml($value) {
        $ret = "";
        $current = null;

        if (empty($value)) {
            return $ret;
        }

        $length = strlen($value);
        for ($i=0; $i < $length; $i++) {
            $current = ord($value{$i});
            if (($current == 0x9) ||
                ($current == 0xA) ||
                ($current == 0xD) ||
                (($current >= 0x20) && ($current <= 0xD7FF)) ||
                (($current >= 0xE000) && ($current <= 0xFFFD)) ||
                (($current >= 0x10000) && ($current <= 0x10FFFF)))
            {
                $ret .= chr($current);
            }
            else {
                $ret .= " ";
            }
        }

        $ret = str_replace('&', ' |and| ', $ret);
        $ret = mb_convert_encoding($ret, 'UTF-8', 'HTML-ENTITIES');

        return $ret;
    }
}