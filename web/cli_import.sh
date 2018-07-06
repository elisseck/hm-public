#!/usr/bin/env bash
##
# Script uses drush to:
#
# * clean the FileMaker XML Document
# * load the XML document contents into a transient table
# * import the transient table contents as Biographies
#
# NOTES:
# =====================
# All directory paths MUST END with a trailing slash!
# Configuration values can also be supplied to /admin/settings/thm-migrate.
# Using the web UI to run the imports are disabled for performance reasons.
#
##
DRUSH_EXEC=../vendor/bin/drush
XML_PATH=/var/www/drupalvm/fm_import/
MEDIA_PATH=/var/www/drupalvm/fm_files/
EMAIL_NOTIFY=tony.taylor@thirdwavellc.com

$("$DRUSH_EXEC" scr cli_import --xml-path="$XML_PATH" --media-path="$MEDIA_PATH" \
  --notify="$EMAIL_NOTIFY")
