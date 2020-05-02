FROM php:7.4-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt-get update && \
    apt-get install -y curl zip unzip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
