#!/usr/bin/env bash

# this script is not meant to be run directly, rather, it
# provides examples for running actions locally or on given
# environments with variables as necessary.

# export THM_WORKING_DIRECTORY="/home/devuser/_backports/db/drupalvm"
# export THM_ZIPPED_FILE="drupal_backup.20190930_045440.sql.gz"
# export THM_SQL_FILE="drupal_backup.20190930_045440.sql"
# export REMOTE_DB_SCHEMA="drupal"
# export LOCAL_DB_SCHEMA="thm_livedev"

# export THM_WORKING_DIRECTORY="/var/www/drupalvm/_backports/db/production"
# export THM_ZIPPED_FILE="thm_livedev_backup.20190929_230120.sql.gz"
# export THM_SQL_FILE="thm_livedev_backup.20190929_230120.sql"
# export REMOTE_DB_SCHEMA="thm_livedev"
# export LOCAL_DB_SCHEMA="drupal"

echo "unzipping database"
gunzip -f ${THM_WORKING_DIRECTORY}/${THM_ZIPPED_FILE}

echo "replacing schema names in sql file"
sed -i "s/${REMOTE_DB_SCHEMA}/${LOCAL_DB_SCHEMA}/g" ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}
# sed -i "s/thm_livedev/drupal/g" /var/www/drupalvm/_backports/db/production/thm_livedev_backup.20190925_222025.sql


echo "loading database into mysql"
mysql < ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}

# on vagrant
# sudo su
# mysql < /var/www/drupalvm/_backports/db/production/thm_livedev_backup.20190923_210411.sql

# echo "removing sql file"
# rm ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}