# The History Makers Public Site

This project repository contains the Drupal 8 scaffolding for the public THM site. In addition, it includes Drupal VM as a composer dependency.

## Getting started
1. Ensure you have the following dependencies installed on your machine:
    * PHP 7
    * Composer >= 1.2.3
    * Ansible >= 2.3.1.0
    * Vagrant >= 1.9.0
    * Note to Linux users:
        * You might need to enable mbstring and phpunit manually on your machine. You can do this by running `sudo apt-get install php7.0-mbstring` and `sudo apt-get install phpunit`.
        * You will need to install NFS, which is a distributed file system protocol used between your local machine and the virtual machine generated with `vagrant up`. You can do so by running `sudo apt install nfs-kernel-server`. You might also have to run `sudo apt install nfs-common` if you have mounting issues after installing. More information about that here: https://help.ubuntu.com/lts/serverguide/network-file-system.html.

2. From your terminal, clone the repository locally using `git clone git@github.com:sardell/hm-public.git`.
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
7. Visit http://dashboard.hm-public.dev/ to take a look at the VM dashboard. From there, you will find links to the following
    * The Drupal site itself.
    * The database management UI (uses [Adminer](https://www.adminer.org/)).
    * A page for viewing log files on the Apache server.(uses [Pimp my log](http://pimpmylog.com/)).
8. Import the current development database (contact someone within the dev team for this).
9. If you need access into the VM, run `vagrant ssh` from the project root.

## Managing Drupal dependencies with Composer

If you would like to add a new core dependency to the project, we use [Composer](https://getcomposer.org/) to do so. For example, if you wanted to add the Migrate Tools module, you would run:

`composer require drupal/migrate_tools`

This allows us to easily manage and share dependencies between a team of developers.
