FROM php:apache

RUN apt-get update \
    && apt-get install -y \
        unzip \
        gnupg \
        zlib1g-dev \
        libpng-dev \
        libxml2-dev \
        libldap2-dev \
        libzip-dev \
    && curl -sL https://deb.nodesource.com/setup_6.x | bash \
    && apt-get install -y nodejs \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install \
        zip \
        mysqli \
        pdo_mysql \
        exif \
        gd \
        soap \
        ldap \
    && a2enmod rewrite \
    && a2enmod headers \
    && a2enmod deflate \
    && a2enmod expires \
    && rm -rf /var/lib/apt/lists/*

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT /RoPA/public
ENV APACHE_SERVER_NAME localhost

RUN sed -i -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -i -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -i -e '/<Directory ${APACHE_DOCUMENT_ROOT}>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && echo "ServerName ${APACHE_SERVER_NAME}" >> /etc/apache2/apache2.conf

COPY php.ini /usr/local/etc/php/php.ini
