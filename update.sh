#! /bin/bash
clear
echo '      ███╗   ██╗ ██████╗ ██████╗ ████████╗███████╗██╗'
echo '      ████╗  ██║██╔═══██╗██╔══██╗╚══██╔══ ██╔════╝██║'
echo '      ██╔██╗ ██║██║   ██║██████╔╝   ██║   █████╗  ██║'
echo '      ██║╚██╗██║██║   ██║██╔══██╗   ██║   ██╔══╝  ██║'
echo '      ██║ ╚████║╚██████╔╝██║  ██║   ██║   ███████╗███████╗'
echo '      ╚═╝  ╚═══╝ ╚═════╝ ╚═╝  ╚═╝   ╚═╝   ╚══════╝╚══════╝'
echo '      ====================================================='
echo '              Welcome to Cheene Platform Update Tool'
echo ''
echo ''
echo '@author:	reza seyf (reza.safe@icloud.com)'
echo '@link  :	www.cheene.ir '
echo '@server_uptime:'; uptime
echo '--------------------------------------------------------------'
echo '<< NOTE >>'
echo 'PLEASE RUN THIS TOOL USING SUPER USER PRIVILEGE (ROOT)'
echo ''
read -r -p "Get Updates From v0.1 Branch? [y/N] " response
    case $response in [yY][eE][sS]|[yY])
	     sudo -u root git pull origin v0.1
	     sudo -u nginx php app/console cheene:actions:load
        echo 'software updated to v0.1 server'
        read
        read -r -p "Update schema for database? [y/N] " response
            case $response in [yY][eE][sS]|[yY])
                  sudo -u nginx php app/console doctrine:cache:clear-metadata
                  sudo -u nginx php app/console doctrine:cache:clear-result
                  php app/console doctrine:schema:update --force
                echo 'schema:update is done'
                echo 'press any key to continue...'
                ;;
                *)
                echo 'skipped schema update.'
                echo 'press any key to continue...'
            ;;
        esac
        read
        read -r -p "Clear Application cache? [y/N] " response
            case $response in [yY][eE][sS]|[yY])
                 chown -R nginx:nginx app/cache
                 chmod -R 777 app/cache/
                 sudo -u nginx php app/console cache:clear --env=dev --no-debug
                 sudo -u nginx php app/console cache:clear --env=prod --no-debug
                 sudo -u nginx php app/console assetic:dump --env=dev
                 sudo -u nginx php app/console assetic:dump --env=prod
            echo 'cache cleared!'
            echo 'press any key to continue...'
            ;;
            *)
            echo 'skipped cache clear.'
            echo 'press any key to continue...'
        ;;
        esac

        read
        read -r -p "Install Assets? [y/N] " response
        case $response in [yY][eE][sS]|[yY])
              sudo -u nginx php app/console assets:install
              sudo -u nginx php app/console assets:install --symlink
            echo 'assets installed!'
            echo 'We are done here buddy!'
            echo 'bye bye ;)'
            ;;
            *)
            echo 'Installing assets has been skipped'
            echo 'press any key to exit...'
        ;;
        esac
    ;;
    *)
    echo 'skipped updating server.'
    echo 'bye bye ;)'
;;
esac