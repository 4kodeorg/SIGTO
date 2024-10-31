FROM php:8.3-apache

RUN apt-get clean && apt-get update && apt-get install -y apt-utils && \
    apt-get upgrade -y && \
    docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli && \
    a2enmod rewrite

COPY ./proyecto var/www/html

EXPOSE 80