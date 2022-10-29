FROM php:8.0-apache
RUN a2enmod rewrite
RUN apt-get update && apt-get upgrade -y

RUN apt-get install -y \
        sendmail \
        libpng-dev \
        zlib1g-dev \
        libzip-dev \
        zip \
        libicu-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev

        
RUN docker-php-ext-install zip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install exif && \
    docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/custom-php.ini
