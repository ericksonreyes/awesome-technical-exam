FROM composer:2.0.12 as build

RUN docker-php-ext-install pdo pdo_mysql bcmath sockets opcache && docker-php-ext-enable opcache

WORKDIR /usr/local/etc/php/conf.d/

COPY config/docker/config/php-cli/php.ini .

WORKDIR /var/www/html

COPY . .

RUN composer --ignore-platform-reqs install --no-dev



FROM php:8.1.1-fpm

RUN docker-php-ext-install pdo pdo_mysql bcmath sockets opcache && docker-php-ext-enable opcache

RUN pecl update-channels

RUN pecl install apcu && docker-php-ext-enable apcu

WORKDIR /usr/local/etc/php/conf.d/

COPY config/docker/config/php-fpm/php.ini .



WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

RUN chown -R www-data:www-data /var/log

RUN chmod a+w /var/log

RUN touch /var/log/php_error.log

COPY --from=build /var/www/html /var/www/html

RUN chmod -R 0755 /var/www/html/storage

EXPOSE 9000