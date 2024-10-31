FROM php:8.3-apache

RUN apt-get clean
RUN apt-get update -y
RUN apt-get install -y apt-utils
RUN apt-get upgrade -y

RUN docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli && \
    a2enmod rewrite

COPY ./proyecto var/www/html

EXPOSE 80