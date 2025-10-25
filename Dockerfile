FROM php:8.2-alpine

WORKDIR /var/www/html

RUN apk add --no-cache libzip-dev zip shadow \
    && docker-php-ext-install pdo pdo_mysql zip bcmath

RUN usermod --uid 1000 www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data . .

RUN chmod u+x /var/www/html/entrypoint.sh

EXPOSE 8000

USER www-data

ENTRYPOINT ["sh","/var/www/html/entrypoint.sh" ]
