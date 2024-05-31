# Note that there currently is an issue with artisan and php 8.1 which will lead to instant termination of the worker process.
# There might be a way to circumvent termination, since the thrown exception is not a terminal error - but the process exits.
# If you find a way to fix this, please contact Konstantin Auffinger @ konstantin.auffinger@inno-brain.de
# Running the worker on pre 8.1 will lead to the worker not understanding 8.1 features, if used.
# Make sure to use a compatible version (preferably the same) to your php.(prod.)dockerfile

FROM php:8.1-fpm-alpine

ENV PHPGROUP=laravel
ENV PHPUSER=laravel

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html/public

RUN docker-php-ext-install pdo pdo_mysql

CMD ["php", "artisan", "queue:listen"]