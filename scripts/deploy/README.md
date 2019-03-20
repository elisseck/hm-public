
- all secrets SSH/Devsite Access/MySQL have been shared with Orin Fink via lastpass

deployment to q/a:

- done using rocketeer
- rocketeer needs to be installed on local machine
- `config.php` and `scm.php` may require secrets in order to use
- deployment is done automatically in one step
- updating core:
  - `composer update drupal/core symfony/* --with-dependencies`

deployment to prod

- done using shell script
- currently stored (~/deploy.sh) on and run from prod
- deployment is done in two phases
  - code/media retrieval and installation is done automatically
  - symlinking the deployment directory `/data/THM-deploy-tmp` to apache directories `/var/www/hm-public` are manual
- updating core:
  - at the moment, done automatically due to a version mismatch
