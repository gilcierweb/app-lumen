FROM php:8.3-fpm-alpine 

LABEL maintainer="gilcierweb@gmail.com"

# Essentials
RUN echo "UTC" > /etc/timezone

RUN set -ex && apk update && apk upgrade # Installations into virtual env so they can be deleted afterwards 

# Installing bash
RUN apk add bash
RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

RUN apk add --no-cache composer
RUN apk add --update --no-cache libgd libpng-dev libjpeg-turbo-dev freetype-dev

RUN apk add jpeg-dev libpng-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


RUN apk add --no-cache zip libzip-dev
RUN apk add icu-dev php-tokenizer
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-configure intl && docker-php-ext-install intl
RUN docker-php-ext-install zip
# RUN docker-php-ext-install tokenizer
RUN apk add php-session \
    php-tokenizer \
    php-xml \
    php-ctype \
    php-curl \
    php-dom \
    php-fileinfo \
    php-mbstring \
    php-openssl \
    php-pdo \
    php-pdo_mysql \
    php-session \
    php-tokenizer \
    php-xml \
    php-ctype \
    php-xmlwriter \
    php-simplexml 

WORKDIR /app
COPY . /app
# RUN composer install

# CMD php -S 0.0.0.0:9000 public/index.php 
EXPOSE 9000