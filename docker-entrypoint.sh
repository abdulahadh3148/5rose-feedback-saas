#!/bin/bash
set -e

# Update Apache port to listen to Render's $PORT (default 80 or 10000)
PORT=${PORT:-80}
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

# Storage link
php artisan storage:link || true

# Production caches
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run database migrations automatically if DB_HOST is provided
if [ -n "$DB_HOST" ]; then
    echo "Running database migrations..."
    php artisan migrate --force --no-interaction || echo "Migration encountered an issue, continuing..."
fi

# Start Apache in the foreground
exec apache2-foreground
