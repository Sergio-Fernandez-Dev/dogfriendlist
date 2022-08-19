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

COPY ./config/apache2.conf /etc/apache2/apache2.conf
COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./config/php.ini /usr/local/etc/php/

RUN a2enmod rewrite

ENTRYPOINT []
CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-enabled/000-default.conf /etc/apache2/ports.conf && docker-php-entrypoint apache2-foreground



