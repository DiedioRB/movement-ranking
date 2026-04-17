FROM php:8.4-fpm

RUN apt-get update && apt-get install -y unzip git

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .
RUN composer install