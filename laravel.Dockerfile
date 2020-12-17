FROM php:7.3-fpm-alpine

ENV REDIS_VERSION 5.2.0

RUN apk --no-cache update && \
    apk --no-cache upgrade && \
    apk --no-cache add \
    curl-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    zlib-dev \
    pcre-dev \
    g++ \
    make \
    autoconf \
    openssl \
    nodejs-npm \
    git \
    bash \
    unzip \
    libzip-dev

RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/$REDIS_VERSION.tar.gz \
        && tar xfz /tmp/redis.tar.gz \
        && rm -r /tmp/redis.tar.gz \
        && mkdir -p /usr/src/php/ext \
        && mv phpredis-* /usr/src/php/ext/redis
RUN docker-php-ext-install \
    curl \
    dom \
    mbstring \
    pdo \
    pdo_mysql \
    redis \
    simplexml \
    opcache \
    xml \
    zip \
  && docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
  && docker-php-ext-install gd \
  && docker-php-ext-install redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && chmod +x /usr/local/bin/composer

RUN rm -rf /var/cache/apk/*

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /usr/share/nginx/html
