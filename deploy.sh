#! /bin/bash
clear
echo "sure?"
    read
    git checkout devel
    sudo -u nginx git pull origin devel
    sudo -u nginx git merge master
    git checkout master

    sudo -u nginx git merge devel
    sudo -u nginx git pull origin master
    php app/console cheene:actions:load

    php app/console doctrine:cache:clear-metadata
    php app/console doctrine:cache:clear-result
    php app/console doctrine:schema:update --force

    php app/console cache:clear --env=dev --no-debug
    sudo php app/console cache:clear --env=prod --no-debug
    sudo php app/console assetic:dump --no-debug --env=prod
    echo 'cleaning cache directory and resetting permissions...'
    sudo chmod -R 775 ./*
    sudo chown -R nginx:nginx./*
    sudo chmod -R 770 app/*
    sudo chmod -R 775 web/*
    sudo chmod -R 775 var/*
    sudo chown -R nginx:nginx web/*
    sudo chmod -R 775 app/cache/*
    sudo chown -R nginx:nginx  app/cache/*
    php app/console assets:install
    php app/console assets:install --symlink
    php app/console assetic:dump
    echo "done..."