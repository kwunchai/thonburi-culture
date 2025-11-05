#!/bin/bash

echo "🌟 Starting Laravel application..."

# Run database migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force --no-interaction

# Clear application cache
echo "🧹 Clearing application cache..."
php artisan cache:clear
php artisan config:clear

# Start the Laravel server
echo "🚀 Starting Laravel server on port ${PORT:-8000}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}