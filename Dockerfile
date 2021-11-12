FROM php:8.1.0RC5-apache-buster

WORKDIR /var/www

COPY . /var/www/

RUN apt-get update && apt-get upgrade -y


RUN apt-get install -y \
    curl \
    git \
    zip \
    vim-tiny \
    zlib1g-dev 

RUN pecl install -f xdebug \ 
&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini

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