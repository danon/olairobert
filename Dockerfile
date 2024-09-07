FROM php:8.3-apache
RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-enable imagick
