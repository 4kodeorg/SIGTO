FROM php:8.3-apache

RUN apt-get clean
RUN apt-get update -y
RUN apt-get install -y apt-utils
RUN apt-get upgrade -y

RUN docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli && \
    a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html
    
COPY ./proyecto var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

EXPOSE 80