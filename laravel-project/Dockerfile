FROM php:8.2-cli-alpine AS builder

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache \
    git zip unzip \
    libpng-dev libxml2-dev oniguruma-dev icu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd


COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

COPY . .

# Оптимизация Laravel для production
RUN composer dump-autoload --optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

FROM php:8.2-fpm-alpine AS production

# Устанавливаем только pdo_mysql (для подключения к базе)
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

# Копируем готовое приложение из первого этапа
COPY --from=builder /app /var/www/html

# Даём веб-серверу права на запись в папки, куда Laravel пишет логи и кэш
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

# Для простоты запускаем встроенный сервер Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]