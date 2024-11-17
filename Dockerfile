FROM php:8.3-apache
RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql
COPY --from=composer /usr/bin/composer /usr/bin/composer

EXPOSE 80