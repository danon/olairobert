FROM php:8.3-apache

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN pecl install imagick
RUN docker-php-ext-enable imagick

RUN yes | pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN xDebugPath='/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini' \
    echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    echo "xdebug.mode=debug " >> $xDebugPath \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    echo "xdebug.start_upon_error=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
