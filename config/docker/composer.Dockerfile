FROM composer:2.0.12

RUN docker-php-ext-install pdo pdo_mysql bcmath sockets opcache && docker-php-ext-enable opcache

WORKDIR /usr/local/etc/php/conf.d/

COPY config/docker/config/php-cli/php.ini .

WORKDIR /var/www/html

ENTRYPOINT [ "composer", "--ignore-platform-reqs" ]