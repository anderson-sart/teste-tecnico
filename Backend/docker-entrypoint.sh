#!/bin/bash
set -e

echo "Waiting for database..."

# Wait for database to be ready (up to 30 seconds)
for i in $(seq 1 30); do
    if php -r "
        \$host = getenv('DB_HOST') ?: 'db';
        \$port = getenv('DB_PORT') ?: '5432';
        \$dbname = getenv('DB_DATABASE') ?: 'softline_db';
        \$user = getenv('DB_USERNAME') ?: 'softline_user';
        \$pass = getenv('DB_PASSWORD') ?: 'softline_pass';
        try {
            new PDO(\"pgsql:host=\$host;port=\$port;dbname=\$dbname\", \$user, \$pass);
            exit(0);
        } catch (Exception \$e) {
            exit(1);
        }
    " 2>/dev/null; then
        echo "Database is ready!"
        break
    fi
    echo "Waiting for database... ($i/30)"
    sleep 1
done

# Run migrations and seeders
if [ -f "artisan" ]; then
    echo "Running migrations..."
    php artisan migrate --force || true
    echo "Running seeders..."
    php artisan db:seed --force || true
fi

# Start PHP server
php -S 0.0.0.0:8000 -t .
