@echo off
cd c:\laragon\www\thonburi-culture
echo Clearing caches and testing activity detail page...
php artisan route:clear
php artisan config:clear
php artisan view:clear

echo.
echo ✅ Activity detail page system completed!
echo.
echo How to test:
echo 1. Visit activities page: http://thonburi-culture.test/activities
echo 2. Click on any activity card to see detail page
echo 3. Test image gallery and lightbox functionality
echo 4. Check related activities section
echo.
echo New routes added:
echo - GET /activity/{activity} → Activity detail page
echo - GET /activities/category/{category} → Activities by category
echo.
pause