#!/usr/bin/env bash
##
#
# Script uses drush to:
#
# * rebuild search index
# * invalidate dynamic data to ensure inclusion of any newly imported vocabulary terms.
#
##
DRUSH_EXEC=../vendor/bin/drush
SEARCH_INDEX=biography_index
CACHE_TAG=bio-search-facets

$("$DRUSH_EXEC" sapi-r "$SEARCH_INDEX" \
  && "$DRUSH_EXEC" php-eval "use \Drupal\Core\Cache\Cache; Cache::invalidateTags([\"$CACHE_TAG\"])")
