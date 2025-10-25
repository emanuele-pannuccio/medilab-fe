#!/bin/ash

if [[ ! -d ./vendor ]]; then
    composer install --no-interaction
fi

exec php artisan serve --host=0.0.0.0 --port=8000
