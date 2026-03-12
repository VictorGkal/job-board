FROM dunglas/frankenphp:php8.2-bookworm

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    openssl \
    tokenizer \
    xml \
    ctype \
    fileinfo \
    curl \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Cache Laravel config
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 8080

CMD php artisan migrate --force \
    && php artisan db:seed --force \
    && php artisan storage:link \
    && frankenphp run --config /Caddyfile
```

Also create a `Caddyfile` in the root:
```
{
    frankenphp
    admin off
}

:{$PORT} {
    root * /app/public
    encode zstd br gzip
    php_server
}