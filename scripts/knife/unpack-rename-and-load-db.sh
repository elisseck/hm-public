#!/usr/bin/env bash


THM_WORKING_DIRECTORY="/home/devuser/_backports/db/production"
THM_ZIPPED_FILE="thm_livedev_backup.20190825_180931.sql.gz"
THM_SQL_FILE="thm_livedev_backup.20190825_180931.sql"
REMOTE_DB_SCHEMA="thm_livedev"
LOCAL_DB_SCHEMA="thm_livedev"



# THM_WORKING_DIRECTORY="/var/www/drupalvm/_backports/db/production"
# THM_ZIPPED_FILE="thm_livedev_backup.20190825_180931.sql.gz"
# THM_SQL_FILE="thm_livedev_backup.20190825_180931.sql"
# REMOTE_DB_SCHEMA="thm_livedev"
# LOCAL_DB_SCHEMA="drupal"

echo "unzipping database"
gunzip -f ${THM_WORKING_DIRECTORY}/${THM_ZIPPED_FILE}

# echo "replacing schema names in sql file"
# sed -i "s/${REMOTE_DB_SCHEMA}/${LOCAL_DB_SCHEMA}/g" ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}
# sed -i "s/thm_livedev/drupal/g" /var/www/drupalvm/_backports/db/production/thm_livedev_backup.20190925_222025.sql


echo "loading database into mysql"
mysql < ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}

# on vagrant
# sudo su
# mysql < /var/www/drupalvm/_backports/db/production/thm_livedev_backup.20190923_210411.sql

# echo "removing sql file"
# rm ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}