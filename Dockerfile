# Dockerfile

# Set env vars for the id of the user which is executing the container
ARG PUID=1000
ARG PGID=1000

# Create args for PHP extensions and PECL packages we need to install.
ARG PHP_EXTS="bcmath mbstring pdo pdo_mysql dom pcntl exif"
ARG PHP_PECL_EXTS="redis"

# ============================================================= COMPOSER =============================================================

FROM composer:2.2 as composer_base
ARG PHP_EXTS
ARG PHP_PECL_EXTS
RUN mkdir -p /var/www/html /var/www/html/bin
WORKDIR /var/www/html
RUN addgroup -S composer \
    && adduser -S composer -G composer \
    && chown -R composer /var/www/html \
    && chmod -R 775 /var/www/html \
    && apk update \
    && apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} ca-certificates libxml2-dev oniguruma-dev openssl-dev \
    && apk add libmcrypt-dev linux-headers \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && pecl install ${PHP_PECL_EXTS} \
    && pecl install -n mcrypt \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-enable ${PHP_PECL_EXTS} \
    && apk del build-dependencies
USER composer
COPY --chown=composer composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
COPY --chown=composer . .
RUN composer install --no-dev --prefer-dist

# ============================================================= NPM =============================================================

FROM node:16-alpine as frontend
COPY --from=composer_base /var/www/html /var/www/html
WORKDIR /var/www/html
RUN npm install && \
    npm run build

# ============================================================= CLI =============================================================
FROM php:8.2-alpine as cli
ARG PHP_EXTS
ARG PHP_PECL_EXTS
ARG PUID
ARG PGID
WORKDIR /var/www/html
RUN apk update && \
    apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} ca-certificates libxml2-dev oniguruma-dev openssl-dev && \
    apk add libmcrypt-dev linux-headers && \
    docker-php-ext-install -j$(nproc) ${PHP_EXTS} && \
    pecl install ${PHP_PECL_EXTS} && \
    pecl install -n mcrypt && \
    docker-php-ext-enable mcrypt && \
    docker-php-ext-enable ${PHP_PECL_EXTS} && \
    apk del build-dependencies
COPY --from=composer_base /var/www/html /var/www/html
COPY --from=frontend /var/www/html/public /var/www/html/public

# ============================================================= FPM =============================================================

FROM php:8.2-fpm-alpine as fpm_server
ARG PHP_EXTS
ARG PHP_PECL_EXTS
ARG PUID
ARG PGID
WORKDIR /var/www/html
RUN apk update && \
    apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} ca-certificates libxml2-dev oniguruma-dev openssl-dev && \
    apk add libmcrypt-dev linux-headers && \
    docker-php-ext-install -j$(nproc) ${PHP_EXTS} && \
    pecl install ${PHP_PECL_EXTS} && \
    pecl install -n mcrypt && \
    docker-php-ext-enable mcrypt && \
    docker-php-ext-enable ${PHP_PECL_EXTS} && \
    apk del build-dependencies
RUN deluser www-data && addgroup -g ${PGID} www-data && adduser -D -H -u ${PUID} -G www-data www-data
USER www-data
COPY --from=composer_base --chown=www-data /var/www/html /var/www/html
COPY --from=frontend --chown=www-data /var/www/html/public /var/www/html/public
COPY php.ini /etc/php/8.2/cli/conf.d/99-sail.ini
RUN php artisan event:cache && php artisan route:cache && php artisan view:cache

# ============================================================= NGINX =============================================================

FROM nginx:1.20-alpine as web_server
WORKDIR /var/www/html
COPY docker/nginx.conf.template /etc/nginx/templates/default.conf.template
COPY --from=frontend /var/www/html/public /var/www/html/public

# ============================================================= CRON =============================================================

FROM cli as cron
WORKDIR /var/www/html
RUN touch laravel.cron && \
    echo "* * * * * cd /var/www/html && php artisan schedule:run" >> laravel.crontab laravel.cron
CMD ["crond", "-l", "2", "-f"]

# ============================================================= DEFAULT STAGE =====================================================

FROM cli