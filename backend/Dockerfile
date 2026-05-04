FROM php:8.2-fpm

# Install dependencies including oniguruma
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis;

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application
COPY . .

# Install PHP dependencies
RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs || true

# Generate artisan key if needed
RUN if [ ! -f .env ]; then cp .env.example .env; fi;

EXPOSE 8000

CMD ["sh", "-c", "php artisan config:cache 2>/dev/null; php artisan serve --host=0.0.0.0 --port=8000"]
