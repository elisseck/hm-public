#!/usr/bin/env bash


# passwordless mysql dump made possible
# by the .my.cnf in the home directory of
# the devuser account on remote machine
# echo "creating the snapshot on the live server"
# knife ssh -z "name:www.thehistorymakers.org" "mysqldump --databases thm_livedev --single-transaction --set-gtid-purged=OFF --add-drop-database | gzip -c > ./_backports/db/thm_livedev_backup.$(date +%Y%m%d_%H%M%S).sql.gz"
# echo "snapshot created on live server"

##
# pull backup to the office backup server
##
# echo "sync snapshot to office backups server"
# knife ssh -z "name:backups01.qa.aura.chicago.thirdwave.3whst.com" "rsync -avzhe ssh devuser@www.thehistorymakers.org:~/_backports/db/ /opt/resilient-stack-migration-tools/production-thm/thm_drupal/"
# echo "snapshot sync'd to office backup server"

##
# pull backup from office server
##
# echo "pulling backup from office server to local drive"
# rsync -avzhe ssh backports@backups01.qa.aura.thirdwave.local:production-thm/thm_drupal/* ./_backports/db/production/
# echo "pulled backup from office server to local drive"

##
# or pull backups directly from production
##
# echo "pulling backup directly from production to local drive"
# rsync -avzhe ssh www.thehistorymakers.org:_backports/db/* ./_backports/db/production/
# echo "pulling backup directly from production to local drive"



##
# or pull onto the QA Server
##
# echo "sync production snapshot to qa server"
# knife ssh -z "name:d8dev.thehistorymakers.org" "rsync -avzhe ssh devuser@www.thehistorymakers.org:~/_backports/db/* ./_backports/db/production/"
# echo "snapshot sync'd to office backup server"



# backup the QA server database.
# echo "creating the snapshot on the qa server"
# knife ssh -z "name:d8dev.thehistorymakers.org" "mysqldump --databases thm_livedev --single-transaction --set-gtid-purged=OFF --add-drop-database | gzip -c > ./_backports/db/qa/thm_qa_backup.$(date +%Y%m%d_%H%M%S).sql.gz"
# echo "snapshot created on live server"
