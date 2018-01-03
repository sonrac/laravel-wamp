#!/usr/bin/env /bin/bash

rm -rf vendor
rm -rf composer.lock
composer install

# Run for lumen
if [ -f "codeception.yml" ]; then
    rm codeception.yml
fi
cp composer.json composer-bkp.json
cp codeception-lumen.yml codeception.yml
sleep 1
rm -rf vendor
rm -rf composer.lock
composer require --dev laravel/lumen-framework:5.* --no-interaction
php tests/replace_autoload.php
vendor/bin/codecept run --coverage --coverage-xml

# Run for laravel
if [ -f "codeception.yml" ]; then
    rm codeception.yml
fi
cp composer-bkp.json composer.json
cp codeception-laravel.yml codeception.yml
sleep 1
rm -rf vendor
rm -rf composer.lock
composer require --dev laravel/framework:5.* --no-interaction
php tests/replace_autoload.php
vendor/bin/codecept run --coverage --coverage-xml

if [ -f "codeception.yml" ]; then
    rm codeception.yml
fi

if [ -f "composer-bkp.json" ]; then
    mv composer-bkp.json composer.json
fi;