# Gunakan image resmi PHP dengan ekstensi yang dibutuhkan
FROM php:8.2-fpm

# Install dependencies OS
RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    vim \
    libonig-dev \
    libxml2-dev \
    npm \
    nodejs \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring xml bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Salin semua file ke dalam container
COPY . .

# Install dependensi PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Salin default supervisor config (opsional, untuk queue atau log multiprocess)
COPY docker/supervisord.conf /etc/supervisord.conf

# Berikan permission (opsional)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Jalankan migrasi awal dan buat storage link (jika diperlukan)
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan config:cache

# Jalankan supervisor (untuk artisan serve, queue, dll)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
