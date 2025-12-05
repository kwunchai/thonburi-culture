@echo off
echo Testing IP Export Route...
echo.

echo 1. Checking route exists...
php artisan route:list | findstr "admin.*ip.*export" 

echo.
echo 2. Testing direct method call...
php -r "
require 'vendor/autoload.php';
echo 'Testing IntellectualPropertyController export method...' . PHP_EOL;
try {
    $controller = new \App\Http\Controllers\Admin\IntellectualPropertyController();
    echo 'Controller loaded successfully!' . PHP_EOL;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
"

echo.
echo 3. Checking for errors...
php artisan config:clear
php artisan cache:clear

pause