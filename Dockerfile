FROM php:8.3-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN yum -y update && yum -y upgrade
RUN a2enmod rewrite

COPY ./proyecto var/www/html

EXPOSE 80