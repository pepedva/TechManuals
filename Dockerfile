FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev libpng-dev libcurl4-openssl-dev \
    libonig-dev libxml2-dev \
    && docker-php-ext-install intl zip gd pdo_mysql curl mbstring \
    && a2enmod rewrite \
    && a2dismod mpm_event \
    && a2enmod mpm_prefork

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

RUN chown -R www-data:www-data writable

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/public>\n    AllowOverride All\n</Directory>' >> /etc/apache2/apache2.conf
