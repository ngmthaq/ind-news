FROM composer:2.7.2 as composer

FROM node:20.12.0 as node

FROM php:8.1-apache

WORKDIR /var/www/html

RUN apt-get update -y

RUN apt-get upgrade -y

RUN apt install git libzip-dev zip unzip -y

RUN docker-php-ext-install zip && docker-php-ext-enable zip

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN docker-php-ext-install pdo && docker-php-ext-enable pdo

RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

COPY php.ini $PHP_INI_DIR/php.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules

COPY --from=node /usr/local/bin/node /usr/local/bin/node

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN npm i -g yarn

RUN chown -R www-data:www-data /var/www/html

RUN chmod -R 755 /var/www/html

RUN a2enmod rewrite

RUN service apache2 restart
