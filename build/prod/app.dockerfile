FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
        libmcrypt-dev \
        && apt-get install -y libpq-dev \
        && docker-php-ext-install -j$(nproc) mcrypt

RUN docker-php-ext-install mbstring exif opcache

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql

COPY php/php.ini    /usr/local/etc/php/