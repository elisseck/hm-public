#!/usr/bin/env bash


THM_WORKING_DIRECTORY="/home/devuser/_backports/db/production"
THM_ZIPPED_FILE="thm_livedev_backup.20190825_180931.sql.gz"
THM_SQL_FILE="thm_livedev_backup.20190825_180931.sql"
REMOTE_DB_SCHEMA="thm_livedev"
LOCAL_DB_SCHEMA="thm_livedev"


echo "unzipping database"
gunzip -f ${THM_WORKING_DIRECTORY}/${THM_ZIPPED_FILE}

# echo "replacing schema names in sql file"
# sed -i "s/${REMOTE_DB_SCHEMA}/${LOCAL_DB_SCHEMA}/g" ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}

echo "loading database into mysql"
mysql < ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}

# echo "removing sql file"
# rm ${THM_WORKING_DIRECTORY}/${THM_SQL_FILE}