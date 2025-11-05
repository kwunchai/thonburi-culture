#!/bin/bash

echo "🚀 Starting Laravel deployment process..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# Generate application key if not exists
echo "🔑 Setting up application key..."
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate --ansi --force

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm ci

# Build frontend assets
echo "🏗️ Building frontend assets..."
npm run build

# Clear and cache configurations
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build process completed successfully!"