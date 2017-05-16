FROM php:fpm

RUN apt-get update && apt-get install -y \
  git

RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
