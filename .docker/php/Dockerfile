FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y

RUN apt-get install -y zlib1g-dev unzip libpq-dev libcurl4-gnutls-dev nginx libonig-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
install-php-extensions pdo pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel laravel

RUN chown -R laravel /var/www/html

USER laravel
