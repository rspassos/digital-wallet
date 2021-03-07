FROM php:7.4-apache

RUN apt-get -y update --fix-missing
RUN apt-get upgrade -y

# Install useful tools
RUN apt-get -y install apt-utils nano wget dialog

# Install important libraries
RUN apt-get -y install --fix-missing apt-utils build-essential git curl libcurl4 zip openssl 

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Other PHP7 Extensions
RUN apt-get -y install libsqlite3-dev libsqlite3-0
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_sqlite
RUN docker-php-ext-install mysqli

# RUN docker-php-ext-install curl
RUN docker-php-ext-install tokenizer
RUN docker-php-ext-install json

RUN apt-get -y install zlib1g-dev libzip-dev
RUN docker-php-ext-install zip

RUN apt-get -y install libicu-dev
RUN docker-php-ext-install -j$(nproc) intl

RUN apt-get -y install libonig-dev
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install gettext

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# Enable apache modules
RUN a2enmod rewrite headers

ENTRYPOINT composer install && /usr/sbin/apache2ctl -D FOREGROUND