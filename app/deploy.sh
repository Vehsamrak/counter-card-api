#!/bin/bash

echo "Changing to project directory ..."
cd ..

echo "Updating code from remote repository ..."
git stash
git pull
git stash pop

echo "Installing composer dependencies ..."
~/composer.phar install
bin/console --env=prod ca:cl

echo "Database migration ..."
bin/console --env=prod doc:mig:mig -n

echo "Clearing symfony cache ..."
bin/console --env=prod ca:cl
