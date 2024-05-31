FROM php:8.1-fpm-alpine

ENV PHPGROUP=laravel
ENV PHPUSER=laravel

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html/public

RUN apk add --no-cache \
    openssl \
    libxml2-dev \
    oniguruma-dev \
    curl-dev \
    zip \
    unzip \
    libzip-dev \
    gd \
    libpng-dev \
    freetype \
    libjpeg-turbo \
    freetype-dev \
    libjpeg-turbo-dev \
    php7-pecl-imagick # Add Imagick

RUN docker-php-ext-install pdo pdo_mysql mbstring tokenizer xml ctype json fileinfo gd zip exif

RUN set -xe && \
    apk add --update --no-cache \
    imap-dev \
    openssl-dev \
    krb5-dev && \
    (docker-php-ext-configure imap --with-kerberos --with-imap-ssl) && \
    (docker-php-ext-install imap > /dev/null) && \
    php -m | grep -F 'imap'

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]