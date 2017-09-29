FROM php:7.1-apache

RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y less vim \
       --no-install-recommends \
    && docker-php-ext-install pdo_mysql \
    && rm -r /var/lib/apt/lists/*

ADD app /var/www/app

ENV APACHE_DOCUMENT_ROOT /var/www/app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable rewrite mode
RUN a2enmod rewrite
