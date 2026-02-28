FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx libicu-dev libzip-dev libpng-dev \
    libcurl4-openssl-dev libonig-dev libxml2-dev \
    && docker-php-ext-install intl zip gd pdo_mysql curl mbstring \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs \
    && chown -R www-data:www-data writable

COPY <<NGINX /etc/nginx/sites-available/default
server {
    listen 80;
    root /var/www/html/public;
    index index.php;
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
NGINX

COPY <<SCRIPT /start.sh
#!/bin/bash
php-fpm -D
nginx -g "daemon off;"
SCRIPT

RUN chmod +x /start.sh
CMD ["/start.sh"]
