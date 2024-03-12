FROM php:8.3-fpm

WORKDIR /var/www/app

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get clean

RUN apt update -y && \
    apt upgrade -y && \
    apt install -y libzip-dev \
        zip \
        curl

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install