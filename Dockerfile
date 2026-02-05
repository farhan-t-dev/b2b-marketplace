FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libzip-dev \
    nginx \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    && docker-php-ext-enable pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application code
COPY . .

# Copy nginx config
COPY docker/nginx/render.conf /etc/nginx/conf.d/default.conf

# Install composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Ensure storage directories exist
RUN mkdir -p storage/framework/cache/data \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/logs

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod +x docker/start.sh

# Expose the port (Render will override this, but good practice)
EXPOSE 80

# Start the application
CMD ["sh", "docker/start.sh"]
