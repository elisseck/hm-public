#!/bin/bash

cd $HM_DEPLOY;

DATE_STAMP=$(date +'%Y%m%d%H%M')

mkdir "hm-pub-$DATE_STAMP";

cd "hm-pub-$DATE_STAMP";

git clone --branch env/production --depth 1 git@github.com:TheHistoryMakers/hm-public.git .

composer install;

rm web/sites/default/settings.php && sudo cp $HM_PUB/web/sites/default/settings.php web/sites/default;
rm web/sites/default/civicrm.settings.php && sudo cp $HM_PUB/web/sites/default/civicrm.settings.php web/sites/default;

sudo rsync -r $HM_PUB/web/sites/default/files/ web/sites/default/files;

sudo chmod go+w web/sites/default/files/temp/
sudo chmod go+w web/sites/default/files/2018-*
sudo chmod -R go+w web/sites/default/files/pictures

sudo chown -R www-data:www-data web;

cd /var/www

sudo ln -s $HM_DEPLOY/hm-pub-$DATE_STAMP/ hm-public-$DATE_STAMP

cd /var/www/hm-public
drush state:set system.maintenance_mode 1 --input-format=integer

cd /var/www
sudo rm hm-public
sudo ln -s $HM_DEPLOY/hm-pub-$DATE_STAMP/ hm-public

cd /var/www/hm-public
sudo -u www-data vendor/drush/drush/drush updb
sudo -u www-data vendor/drush/drush/drush cr

drush state:set system.maintenance_mode 0 --input-format=integer
