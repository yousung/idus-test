FROM php:7.4-fpm-alpine

ADD ./www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 idus && adduser -G idus -g idus -s /bin/sh -D idus

RUN mkdir -p /var/www/html

RUN chown idus:idus /var/www/html

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-enable opcache;