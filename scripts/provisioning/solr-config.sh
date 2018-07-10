#!/bin/bash

sudo -u solr /opt/solr/bin/solr create_core -c thm_bios

cd /var/www/drupalvm/web/modules/contrib/search_api_solr/solr-conf/6.x

sudo -u solr cp -R * /var/solr/data/thm_bios/conf