#!/bin/bash

# https://stackoverflow.com/questions/43243732/laravel-5-env-always-returns-null
# php artisan config:cache
php artisan cache:clear

# https://stackoverflow.com/questions/43243732/laravel-5-env-always-returns-null
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
composer dump-autoload

#re cache config
php artisan config:cache
