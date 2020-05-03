FROM php:7.4-fpm

# Following installation instructions from https://grpc.io/docs/quickstart/php/
RUN apt-get update && \
    apt-get install -y curl zip unzip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install libz-dev
RUN pecl install grpc
RUN docker-php-ext-enable grpc

RUN apt-get install wget
RUN cd / && \
    wget https://github.com/protocolbuffers/protobuf/releases/download/v3.11.4/protoc-3.11.4-linux-x86_64.zip && \
    unzip -d protoc protoc-3.11.4-linux-x86_64.zip && \
    rm -rf protoc-3.11.4-linux-x86_64.zip
ENV PATH="/protoc/bin:${PATH}"

RUN pecl install protobuf
RUN docker-php-ext-enable protobuf

# https://grpc.io/docs/quickstart/php/#php-protoc-plugin
RUN apt-get install -y autoconf libtool && \
    git clone -b v1.28.1 https://github.com/grpc/grpc && \
    cd grpc && \
    git submodule update --init && \
    make grpc_php_plugin

ENV PATH="/var/www/html/grpc/bins/opt:${PATH}"

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

# Watch proto files to regenerate grpc files
RUN docker-php-ext-install pcntl
RUN composer global require seregazhuk/php-watcher
ENV PATH="/root/.composer/vendor/bin:${PATH}"
COPY ./build_protos.sh /
COPY ./php-watcher.yml /
ENTRYPOINT ["php-watcher", "/build_protos.sh", "--config", "/php-watcher.yml"]
