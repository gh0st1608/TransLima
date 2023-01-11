FROM php:7.2-apache
RUN docker-php-ext-install pdo pdo_mysql mysqli && docker-php-ext-enable pdo pdo_mysql mysqli
#RUN apt-get update && apt-get upgrade -y