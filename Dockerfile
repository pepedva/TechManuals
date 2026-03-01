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

RUN echo 'server { \n\
    listen $PORT; \n\
    root /var/www/html/public; \n\
    index index.php; \n\
    location / { try_files $uri $uri/ /index.php?$query_string; } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
}' > /etc/nginx/sites-available/default

RUN echo '#!/bin/bash\n\
sed -i "s/\$PORT/$PORT/g" /etc/nginx/sites-available/default\n\
php-fpm -D\n\
nginx -g "daemon off;"' > /start.sh && chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
