FROM php:fpm

RUN apt-get update && apt-get install -y \
  git \
  zlib1g-dev

RUN docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
