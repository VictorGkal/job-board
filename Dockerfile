FROM dunglas/frankenphp:php8.2-bookworm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git curl zip unzip ca-certificates gnupg

# Install Node 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN install-php-extensions \
    pdo_mysql mbstring openssl tokenizer \
    xml ctype fileinfo curl zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 8080

CMD php artisan config:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force \
    && php artisan db:seed --force \
    && php artisan storage:link \
    && frankenphp run --config /Caddyfile