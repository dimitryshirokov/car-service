# registry.gitlab.develz.ru/application/bki-service:php-7.4-gitlab
FROM registry.gitlab.develz.ru/application/bki-service:php-7.4

USER root

RUN apk add --no-cache --update $PHPIZE_DEPS \
    git \
    zip \
    rsync \
    openssh-client \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer global require hirak/prestissimo \
    && pecl install pcov ast \
    && docker-php-ext-enable pcov ast \
    && apk del $PHPIZE_DEPS \
    && rm -rf /tmp/* /var/tmp/* /usr/share/doc/* /var/cache/apk/* /usr/share/php7
