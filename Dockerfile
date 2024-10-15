FROM php:8.3-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
RUN a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ./proyecto var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80