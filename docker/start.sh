#!/bin/sh

# Replace ${PORT} in nginx config
sed -i "s/\${PORT}/${PORT:-80}/g" /etc/nginx/conf.d/default.conf

# Run migrations (optional, can be dangerous if not handled carefully)
# php artisan migrate --force

# Optimize Laravel if APP_KEY is set
if [ -n "$APP_KEY" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Start PHP-FPM
php-fpm -D

# Start Nginx
nginx -g "daemon off;"
