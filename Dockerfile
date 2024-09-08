FROM php:apache

RUN apt-get update
RUN a2enmod rewrite

COPY ./proyecto var/www/html

EXPOSE 80