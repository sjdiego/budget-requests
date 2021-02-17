FROM php:7.3-fpm-alpine

RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer