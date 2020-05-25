# car-service-nginx
FROM nginx:alpine

MAINTAINER dimitryshirokov@yandex.ru

ENV TZ=Europe/Moscow \
    LANG=en_US.UTF-8 \
    LANGUAGE=en_US.UTF-8 \
    LC_CTYPE=en_US.UTF-8 \
    LC_ALL=en_US.UTF-8

ARG UID=1001
ARG GID=1001

RUN apk add --update --no-cache \
    tzdata \
    shadow \
    && rm -rf /tmp/* /var/tmp/* /usr/share/doc/* /var/cache/apk/* \
    && cp /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && usermod -u $UID nginx -s /bin/sh && groupmod -g $GID nginx \
    && chown nginx:nginx /var/cache/nginx -R \
    && chown nginx:nginx /var/log/nginx -R \
    && rm /etc/nginx/conf.d/*

USER nginx
WORKDIR /var/www/car-service/current
