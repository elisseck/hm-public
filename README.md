# The HistoryMakers Public Site

This project repository contains the Drupal 8 scaffolding for the public THM site. In addition, it includes Drupal VM as a composer dependency.

## Getting started
1. Ensure you have the following dependencies installed on your machine:
    * [PHP 7](http://php.net/)
    * [Composer](https://getcomposer.org/) >= 1.2.3
    * [Ansible](http://docs.ansible.com/ansible/latest/intro.html) >= 2.3.1.0 (Used by Vagrant. We recommend using `brew install ansible` if you're on a Mac.)
    * [Vagrant](https://www.vagrantup.com/intro/index.html) >= 1.9.0
    * [VirtualBox](https://www.virtualbox.org/) >= 5.1
    * Note to Linux users:
        * You might need to enable mbstring and phpunit manually on your machine. You can do this by running `sudo apt-get install php7.0-mbstring` and `sudo apt-get install phpunit`.
        * You will need to install NFS, which is a distributed file system protocol used between your local machine and the virtual machine generated with `vagrant up`. You can do so by running `sudo apt install nfs-kernel-server`. You might also have to run `sudo apt install nfs-common` if you have mounting issues after installing. More information about that here: https://help.ubuntu.com/lts/serverguide/network-file-system.html.

2. From your terminal, clone the repository locally using `git clone git@github.com:/TheHistoryMakers/hm-public.git`.
3. From the root of the project, install all Composer dependencies by running `composer install`.
4. Inside the config folder, create a new file called `local.config.yml` and add the following, keeping in mind to fill in the path to your project locally without the double curly braces:
```
vagrant_synced_folders:
  # The first synced folder will be used for the default Drupal installation, if
  # any of the build_* settings are 'true'. By default the folder is set to
  # the drupal-vm folder.
  - local_path: {{ YOUR_PATH_TO_HM-PUBLIC_PROJECT }}
    destination: /var/www/drupalvm
    type: nfs
    create: true
```
5. Front the root of the project, run `vagrant plugin install vagrant-bindfs` in your terminal.
6. From the root of the project, run `vagrant up` in your terminal. the first time you run the command, Drupal VM will create a new virtual machine for you. This will take a few minutes to download and setup.
7. Visit http://dashboard.hm-public.test/ to take a look at the VM dashboard. From there, you will find links to the following
    * The Drupal site itself.
    * The database management UI (uses [Adminer](https://www.adminer.org/)).
    * A page for viewing log files on the Apache server.(uses [Pimp my log](http://pimpmylog.com/)).
8. Import the current development database (contact someone within the dev team for this).
9. If you need access into the VM, run `vagrant ssh` from the project root.

## Managing Drupal dependencies with Composer

If you would like to add a new core dependency to the project, we use [Composer](https://getcomposer.org/) to do so. For example, if you wanted to add the Migrate Tools module, you would run:

`composer require drupal/migrate_tools`

This allows us to easily manage and share dependencies between a team of developers.

## Ensure your local environment uses a sandbox Authorize.net configuration

It is **imperative** that you create a local configuration for the Authorize.net feature.  Without this step, you risk creating orders against a configuration intended for another environment since there is an _option_ to configure these secrets through the Drupal GUI.  

In order to use a local configuration, place the following block within a `settings.local.php` file inside `/web/sites/default`

```php
/**
* Local configuration for the Authorize.net test environment
*/

$config['commerce_payment.commerce_payment_gateway.authorize_net']['configuration'] = [
 'api_login' => '{your authorize.net api login}',
 'transaction_key' => '{your authorize.net api transaction key}',
 'client_key' => '{your authorize.net client key}',
 'mode' => 'test'
];
```

## Getting MySQL Dump into your local build

In order to safely make a backup from another database server

    mysqldump --databases thm_livedev --single-transaction --set-gtid-purged=OFF --add-drop-database --user=devuser --password | gzip -c > ./backports/db/thm_livedev_backup.$(date +%Y%m%d_%H%M%S).sql.gz

Bring the backup down to local and push it up into the vagrant machine
  
    rsync -v devuser@devwww.thehistorymakers.org:~/backports/db/ ./
    vagrant upload ./thm_livedev_backup.20190501_204210.sql.gzip

Get into vagrant machine and switch to root user, unzip the db, replace instances of the source database name with the drupal name, import the DB to mysql and remove the imported file (unless you want to keep it around for repeat testing)

    vagrant ssh
    sudo su root
    cd /home/vagrant
    gunzip thm_livedev_backup.{current_file}.sql.gzip
    sed -i 's/thm_livedev/drupal/g' thm_livedev_backup.{current_file}.sql
    mysql < thm_livedev_backup.{current_file}.sql
    rm thm_livedev_backup.{current_file}.sql

## First boot of app after DB import

Upon starting the DB after an import, step through the install and enter DB credentials.  Then you will also need to rebuild the Cache.  This can be accomplished by going into the vagrant host `vagrant ssh` and issuing a Drush coammand
    
    cd /var/www/drupalvm/web
    drush cr
    
## Adding items to the SOLR index.

When you first start up, and after you've imported the DB, the Solr collection will need to be populated with the data from the database.  In order to do this, run the following.

    drush sapi-c && drush sapi-r && drush sapi-i
    
## Working on this project

In this project, we use [GitHub Flow](https://guides.github.com/introduction/flow/), a lightweight, branch-based workflow that supports teams and projects where deployments are made regularly. In addition, we would appreciate if you fork from this project and create a feature branch from your fork. When your work is ready, you can create a Pull Request from your forked project's feature branch into this repository's master branch. This helps us keep the branch structure of this repo clean.
