
# Create args for PHP extensions and PECL packages we need to install.
# This makes it easier if we want to install packages,
# as we have to install them in multiple places.
# This helps keep ou Dockerfiles DRY -> https://bit.ly/dry-code
# You can see a list of required extensions for Laravel here: https://laravel.com/docs/9.x/deployment#server-requirements
ARG PHP_EXTS="pdo pdo_mysql"


# ============================================================= CLI =============================================================

# For running things like migrations, and queue jobs,
# we need a CLI container.
# It contains all the Composer packages,
# and just the basic CLI "stuff" in order for us to run commands,
# be that queues, migrations, tinker etc.
FROM php:8.1-alpine as cli

# We need to declare that we want to use the args in this build step
ARG PHP_EXTS
ARG PHP_PECL_EXTS

WORKDIR /var/www/html

# We need to install some requirements into our image,
# used to compile our PHP extensions, as well as install all the extensions themselves.
# You can see a list of required extensions for Laravel here: https://laravel.com/docs/8.x/deployment#server-requirements
RUN apk update && \
    docker-php-ext-install -j$(nproc) ${PHP_EXTS}

RUN set -xe && \
    apk add --update linux-headers &&\
    apk add --update --no-cache \
    imap-dev \
    openssl-dev \
    krb5-dev && \
    (docker-php-ext-configure imap --with-kerberos --with-imap-ssl) && \
    (docker-php-ext-install imap > /dev/null) && \
    php -m | grep -F 'imap'

# ============================================================= CRON =============================================================

# We need a CRON container to the Laravel Scheduler.
# We'll start with the CLI container as our base,
# as we only need to override the CMD which the container starts with to point at cron
FROM cli as cron

WORKDIR /var/www/html

# We want to create a laravel.cron file with Laravel cron settings, which we can import into crontab,
# and run crond as the primary command in the forground
RUN touch laravel.cron && \
    echo "* * * * * cd /var/www/html && php artisan schedule:run" >> laravel.cron && \
    crontab laravel.cron

CMD ["crond", "-l", "2", "-f"]

# ============================================================= WORKER =============================================================


FROM cli as worker

WORKDIR /var/www/html

# We want to create a laravel.cron file with Laravel cron settings, which we can import into crontab,
# and run crond as the primary command in the forground
RUN touch laravel.cron && \
    echo "* * * * * cd /var/www/html && php artisan queue:work --stop-when-empty" >> laravel.cron && \
    crontab laravel.cron

CMD ["crond", "-l", "2", "-f"]

