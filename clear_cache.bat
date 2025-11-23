@echo off
cd c:\laragon\www\thonburi-culture
echo Clearing caches...
php artisan route:clear
php artisan config:clear
php artisan cache:clear
echo Done! Please try accessing admin activities again.