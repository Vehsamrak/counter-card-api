#!/bin/bash

echo "Setting parameters ..."
if [ ! -f /project/app/config/parameters.yml ]; then
    echo "Parameters are not found! Copying from .dist"
    cp /project/app/config/parameters.yml.dist /project/app/config/parameters.yml
fi

echo "Starting PHP-fpm ..."
service php7.1-fpm start

echo "Installing composer dependencies ..."
cd /project
/composer.phar install

/project/bin/console --env=prod ca:cl
/project/bin/console --env=dev ca:cl
/project/bin/console --env=test ca:cl

echo "Creating databases ..."
/project/bin/console --env=prod doc:dat:cr
/project/bin/console --env=dev doc:dat:cr

echo "Database migration ..."
/project/bin/console --env=prod doc:mig:mig -n
/project/bin/console --env=dev doc:mig:mig -n

echo "Clearing symfony cache ..."
/project/bin/console --env=prod ca:cl

echo "Starting Nginx ..."
nginx -g 'daemon off;'
