FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y build-essential libargon2-dev

RUN pecl download argon2
RUN tar xvzf argon2-*.tgz
RUN cd argon2-* && phpize && ./configure && make && make install

RUN echo "extension=argon2.so" > /usr/local/etc/php/conf.d/argon2.ini


# RUN pecl install xdebug && docker-php-ext-enable xdebug