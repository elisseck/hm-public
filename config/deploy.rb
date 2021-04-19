# config valid for current version and patch releases of Capistrano
lock "~> 3.14.1"

set :application, 'hm-public'
set :repo_url, 'git@github.com:thirdwavellc/hm-public.git'
set :branch, 'env/qa'
set :deploy_to, '/var/www/hm-public'
set :composer_install_flags, '--no-dev --no-interaction --quiet --optimize-autoloader'

append :linked_files, 'web/sites/default/settings.php'
append :linked_files, 'web/sites/default/civicrm.settings.php'
append :linked_dirs, 'web/sites/default/files'
append :linked_dirs, 'vendor/civicrm/civicrm-core/packages'


before 'deploy:starting', 'drupal:site_offline'
after 'deploy:finished', 'drupal:site_online'

SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"

namespace :deploy do
  after :starting, 'composer:install_executable'
end

namespace :drupal do
  desc 'Set the site offline'
  task :site_offline do
    on roles(:app), in: :sequence, wait: 5 do
      within release_path do
        execute 'vendor/drush/drush/drush', 'state:set system.maintenance_mode 1 --input-format=integer'

      end
    end
  end

  desc 'Set the site online'
  task :site_online do
    on roles(:app), in: :sequence, wait: 5 do
      within release_path do
        execute 'vendor/drush/drush/drush', 'state:set system.maintenance_mode 0 --input-format=integer'

      end
    end
  end

  namespace :cache do
    desc 'Rebuild cache'
    task :rebuild do
      on roles(:app), in: :sequence, wait: 5 do
        within release_path do
          execute 'vendor/drush/drush/drush', 'cache:rebuild'
        end
      end
    end
  end
end
