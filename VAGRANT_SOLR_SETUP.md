
+ check status of server
`/opt/solr/bin/solr status`

+ the following creates a solr "core" /var/solr/data/<core_name>
`sudo -u solr /opt/solr/bin/solr create_core -c <core_name>`

+ the next two commands will configure your solr instance for drupal use
`cd /var/www/drupalvm/web/modules/contrib/search_api_solr/solr-conf/6.x`

`sudo -u solr cp -R * /var/solr/data/<core_name>/conf`
