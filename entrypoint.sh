#!/bin/ash

if [[ ! -d ./vendor ]]; then
    composer install --no-interaction
    chown 1000:1000 -R .
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --force
fi

php artisan serve --host=0.0.0.0 --port=8000
