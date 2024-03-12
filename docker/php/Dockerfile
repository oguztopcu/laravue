FROM php:8.3-fpm

WORKDIR /var/www/app

RUN apt-get clean

RUN apt update -y && \
    apt upgrade -y && \
    apt install -y libzip-dev \
        zip \
        curl

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# RUN curl -fsSL https://deb.nodesource.com/setup_21.x | bash -
# RUN apt install -y nodejs
# RUN node -v
# RUN npm -v
# RUN npm install