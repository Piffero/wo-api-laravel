FROM php:8.1.0-fpm

ARG UID
ARG GID

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    libldap2-dev \
    git \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl bcmath
RUN docker-php-ext-configure bcmath --enable-bcmath
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/
RUN docker-php-ext-install ldap
RUN docker-php-ext-install gd

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
COPY --chown=www:www . /var/www/
RUN chmod -R 755 /var/www/

USER www

EXPOSE 3000
CMD ["php", "-S", "0.0.0.0:3000", "-t", "public/"]