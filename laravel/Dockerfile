FROM php:8.2-fpm

# Install dependency
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring xml

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project
COPY . .

# Install laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permission
RUN chmod -R 777 storage bootstrap/cache

CMD [ "php-fpm" ]