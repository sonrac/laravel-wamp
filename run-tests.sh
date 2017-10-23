#!/usr/bin/env bash
rm -rf vendor
rm -rf composer.lock
composer install

# Run for lumen
composer require --dev laravel/lumen-framework --no-interaction
./vendor/bin/codecept run --coverage --coverage-xml
composer remove --dev laravel/lumen-framework --no-interaction

# Run for laravel
composer require --dev laravel/framework --no-interaction
./vendor/bin/codecept run --coverage --coverage-xml
composer remove --dev laravel/framework --no-interaction
