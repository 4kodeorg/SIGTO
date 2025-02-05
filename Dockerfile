FROM php:8.3-apache

RUN apt-get clean
RUN apt-get update -y
RUN apt-get install -y apt-utils
RUN apt-get upgrade -y

RUN apt-get -y install git

RUN docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli && \
    a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

COPY ./proyecto /var/www/html
WORKDIR /var/www/html

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
RUN composer require paypal/paypal-server-sdk:0.5.1 --no-interaction --prefer-dist --optimize-autoloader

EXPOSE 80