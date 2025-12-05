@echo off
echo Testing Laravel PORT configuration...

echo Setting PORT environment variable to 3000...
set PORT=3000

echo Starting Laravel server on port 3000...
php artisan serve --host=0.0.0.0 --port=3000

pause