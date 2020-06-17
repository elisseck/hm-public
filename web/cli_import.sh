#!/usr/bin/env bash
##
# Script uses drush to:
#
# * clean the FileMaker XML Document
# * load the XML document contents into a transient table
# * import the transient table contents as Biographies
# * clear and rebuild the search index
# * reset the cache on search facet (autocomplete) data
#
# NOTES:
# =====================
# All directory paths MUST END with a trailing slash!
# Configuration values can also be supplied to /admin/settings/thm-migrate.
# Using the web UI to run the imports are disabled for performance reasons.
#
##
DRUSH_EXEC=../vendor/bin/drush

../vendor/bin/drush scr cli_import \
  && ../vendor/bin/drush sapi-c biography_index \
  && ../vendor/bin/drush sapi-i biography_index \
  && ../vendor/bin/drush php-eval "use \Drupal\Core\Cache\Cache; Cache::invalidateTags(['bio-search-facets']);" \
  && ../vendor/bin/drush @self sqlq --file ../scripts/sql/select-marc-url-redirects.sql --result-file ../marc-map.txt \
  && /usr/sbin/httxt2dbm -i ../marc-map.txt -o ../marc-map.map