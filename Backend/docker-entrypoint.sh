#!/bin/bash
set -e

# Wait for database
sleep 5

# Run migrations if artisan exists
if [ -f "artisan" ]; then
    php artisan migrate --force 2>/dev/null || true
    php artisan db:seed --force 2>/dev/null || true
fi

# Start PHP server
php -S 0.0.0.0:8000 -t .
