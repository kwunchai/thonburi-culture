@echo off
cd c:\laragon\www\thonburi-culture
echo Testing multiple image upload system...
echo.
echo Running tests to verify the multiple image functionality...
echo.

REM Test if migration ran successfully
echo 1. Checking database structure...
php artisan tinker --execute="use Illuminate\Support\Facades\Schema; echo 'Images column exists: ' . (Schema::hasColumn('activities', 'images') ? 'YES' : 'NO');"

echo.
echo 2. Checking if Activity model can handle images array...
php artisan tinker --execute="$activity = App\Models\Activity::first(); echo 'Sample activity found: ' . ($activity ? 'YES' : 'NO'); if($activity) { echo PHP_EOL . 'Images array cast working: ' . (is_array($activity->images) ? 'YES' : 'NO'); }"

echo.
echo 3. Clear cache and optimize...
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo.
echo ✅ Multiple image upload system setup completed!
echo.
echo Instructions:
echo 1. Log in to admin panel: http://thonburi-culture.test/login
echo 2. Go to Activities Management: http://thonburi-culture.test/admin/activities
echo 3. Create or edit activity to test multiple image uploads
echo.
pause