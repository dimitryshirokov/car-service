# car-service-main
FROM php:7.4-fpm-alpine

MAINTAINER dimitryshirokov@yandex.ru

ENV TZ=Europe/Moscow \
    LANG=en_US.UTF-8 \
    LANGUAGE=en_US.UTF-8 \
    LC_CTYPE=en_US.UTF-8 \
    LC_ALL=en_US.UTF-8

ARG UID=1001
ARG GID=1001

RUN apk --update add --no-cache \
    curl \
    bash \
    libintl \
    tzdata \
    shadow \
    oniguruma-dev \
    $PHPIZE_DEPS \
    # persistent-deps: intl
        icu-dev \
    # persistent-deps: memcached
        libmemcached-libs \
        zlib \
	    zlib-dev \
    # build-deps: memcached \
        libmemcached-dev \
        cyrus-sasl-dev \
    && set -xe \
    && pecl install memcached \
    && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/20_memcached.ini \
    && docker-php-ext-configure intl \
    && docker-php-ext-install ctype iconv pdo_mysql intl mbstring bcmath opcache pcntl \
    && apk del $PHPIZE_DEPS \
    # build-deps: memcached \
        libmemcached-dev \
        cyrus-sasl-dev \
    && rm -rf /tmp/* /var/tmp/* /usr/share/doc/* /var/cache/apk/* /usr/share/php7 \
    && cp /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && usermod -u $UID www-data -s /bin/bash && groupmod -g $GID www-data \
    && chmod 0777 /var/log

USER www-data
WORKDIR /var/www/car-service/current
