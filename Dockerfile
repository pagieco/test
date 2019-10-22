FROM php:7.3-fpm

COPY ./container-startup.sh /usr/local/bin/start
COPY ./.service-resources/dev/php/php.ini /etc/php/7.3/fpm/conf.d/99-overrides.ini

RUN apt-get update
RUN apt-get install -y \
	mariadb-client \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libicu-dev \
	--no-install-recommends

WORKDIR /app

# Extensions
RUN docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install pdo_mysql gd json pcntl bcmath intl

# MEMCACHED
RUN apt-get install -y libmemcached-dev
RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN chmod u+x /usr/local/bin/start
