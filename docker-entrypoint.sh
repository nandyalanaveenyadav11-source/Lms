#!/bin/bash
set -e

# Ensure .env exists
if [ ! -f "/var/www/html/.env" ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

# Ensure database directory exists
mkdir -p /var/www/html/database



# Set proper permissions again for volumes
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run key generation if not set
if grep -q "APP_KEY=$" .env; then
    echo "Generating app key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

exec "$@"
