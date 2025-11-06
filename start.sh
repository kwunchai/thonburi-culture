#!/bin/bash
set -e

echo "🌟 Starting Laravel application..."

# Clear caches first
echo "🧹 Clearing application cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Run database migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force --no-interaction

# Wait a moment for everything to settle
echo "⏳ Waiting for initialization..."
sleep 5

# Test Laravel readiness
echo "🔍 Testing Laravel readiness..."
php artisan --version

# Start the Laravel server
echo "🚀 Starting Laravel server on port ${PORT:-8000}..."
echo "📍 Server will bind to: 0.0.0.0:${PORT:-8000}"
echo "🔗 Health check will be available at: /health.php"

# Ensure PORT is set
if [ -z "$PORT" ]; then
    echo "⚠️  WARNING: PORT environment variable not set, using default 8000"
    export PORT=8000
fi

exec php artisan serve --host=0.0.0.0 --port=$PORT