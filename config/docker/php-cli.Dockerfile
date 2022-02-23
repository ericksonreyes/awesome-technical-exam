FROM composer:2.0.12 as build

RUN docker-php-ext-install pdo pdo_mysql bcmath sockets opcache && docker-php-ext-enable opcache

WORKDIR /usr/local/etc/php/conf.d/

COPY config/docker/config/php-cli/php.ini .

WORKDIR /var/www/html

COPY . .

RUN composer --ignore-platform-reqs install



FROM php:8.1.1-cli-alpine

RUN apk update && apk add curl git wget

RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS

RUN pecl update-channels

RUN docker-php-ext-install pdo pdo_mysql bcmath sockets opcache && docker-php-ext-enable opcache && pecl install apcu && docker-php-ext-enable apcu && pecl install pcov && docker-php-ext-enable pcov

WORKDIR /usr/local/etc/php/conf.d/

COPY config/docker/config/php-cli/php.ini .



WORKDIR /var/www/html

COPY --from=build /var/www/html /var/www/html

RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 0755 /var/www/html/storage

COPY . .

ENTRYPOINT [ "php"]