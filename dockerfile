FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev libpq-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd \
    && a2enmod rewrite headers

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN echo "APP_KEY=base64:B4pAsDlZJOJ2+cvIGe8KWSLhZJCiHyjGpYI4RrsPgkA=" > .env \
    && echo "APP_ENV=production" >> .env \
    && echo "APP_DEBUG=false" >> .env \
    && echo "DB_CONNECTION=pgsql" >> .env \
    && echo "DB_HOST=dpg-d8enbuc2m8qs73940q10-a" >> .env \
    && echo "DB_PORT=5432" >> .env \
    && echo "DB_DATABASE=toko_thrift_db" >> .env \
    && echo "DB_USERNAME=toko_thrift_db_user" >> .env \
    && echo "DB_PASSWORD=HeA9tipv0f6Cso1EeRtNOIU01d6TfcKN" >> .env \
    && echo "SESSION_DRIVER=database" >> .env \
    && echo "CACHE_STORE=database" >> .env

RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
        Options -Indexes\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["sh", "-c", "php artisan config:cache && php artisan migrate --force 2>&1 | grep -v 'already exists' || true && php artisan db:seed --force && apache2-foreground"]