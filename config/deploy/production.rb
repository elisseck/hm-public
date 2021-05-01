server "www.thehistorymakers.org", user: "devuser", roles: %w{web app db}


set :repo_url, 'git@github.com:thirdwavellc/hm-public.git'
set :branch, 'env/production'
set :deploy_to, '/data/www/hm-public'
