server "d8dev.thehistorymakers.org", user: "devuser", roles: %w{web app db}

SSHKit.config.command_map[:composer] = "php #{shared_path.join("composer.phar")}"
