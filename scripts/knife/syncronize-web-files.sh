#!/usr/bin/env bash

# echo sync from Production back to QA
# knife ssh -z "name:d8dev.thehistorymakers.org" "rsync -avzhe ssh devuser@www.thehistorymakers.org:/var/www/hm-public/web/sites/default/files/* /data/drupal/thm-d8/shared/web/sites/default/files/"
# echo "snapshot sync'd to office backup server"