# Railway Environment Variables Setup Guide

## Required Environment Variables for Railway Deployment

Copy these variables to your Railway project settings:

### Application Settings
```
APP_NAME="วัฒนธรรมเขตธนบุรี"
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=Asia/Bangkok
APP_URL=https://your-railway-domain.railway.app
```

### Database Settings (Railway PostgreSQL)
```
DB_CONNECTION=pgsql
DB_HOST=${{PGHOST}}
DB_PORT=${{PGPORT}}
DB_DATABASE=${{PGDATABASE}}
DB_USERNAME=${{PGUSER}}
DB_PASSWORD=${{PGPASSWORD}}
```

### Cache & Session Settings
```
CACHE_DRIVER=database
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

### Queue Settings
```
QUEUE_CONNECTION=database
```

### Mail Settings (Optional)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### File Storage Settings
```
FILESYSTEM_DISK=public
```

### Logging Settings
```
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error
```

## Railway Deploy Commands

### Build Command (in Railway Settings):
```bash
composer install --optimize-autoloader --no-dev && npm ci && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### Start Command (in Railway Settings):
```bash
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

## Manual Deploy Steps:

1. Connect GitHub repository to Railway
2. Add PostgreSQL database service
3. Set environment variables above
4. Deploy!

## Post-Deploy Commands (run in Railway shell if needed):
```bash
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```