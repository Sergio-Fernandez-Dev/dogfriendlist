FROM php:7.4-apache

COPY /db/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/

WORKDIR /var/www

RUN apt-get update && apt-get upgrade -y

RUN apt-get install -y \
    curl \
    git \
    zip \
    zlib1g-dev

RUN pecl install xdebug

RUN docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql 

RUN docker-php-ext-enable \
    xdebug \
    mysqli \
    pdo_mysql 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN a2enmod rewrite

RUN service apache2 restart