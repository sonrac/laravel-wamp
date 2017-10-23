#!/usr/bin/env bash

rm -rf vendor
rm -rf composer.lock
composer install

# Run for lumen
if [[ -f "codeception.yml" ]]; then
    rm codeception.yml
fi
cp codeception-lumen.yml codeception.yml
rm -rf vendor
rm -rf composer.lock
composer require --dev laravel/lumen-framework:5.* --no-interaction
./vendor/bin/codecept run --coverage --coverage-xml
composer remove --dev laravel/lumen-framework --no-interaction

# Run for laravel
if [[ -f "codeception.yml" ]]; then
    rm codeception.yml
fi
cp codeception-laravel.yml codeception.yml
rm -rf vendor
rm -rf composer.lock
composer require --dev laravel/framework:5.* --no-interaction
./vendor/bin/codecept run --coverage --coverage-xml
composer remove --dev laravel/framework --no-interaction
if [[ -f "codeception.yml" ]]; then
    rm codeception.yml
fi
