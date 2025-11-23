@echo off
cd c:\laragon\www\thonburi-culture
echo Starting Laravel server for testing...
echo.
echo Open your browser and go to: http://localhost:8000/test-auth
echo.
echo Admin credentials:
echo Email: admin@test.com
echo Password: password123 (or the password you set)
echo.
echo Press Ctrl+C to stop the server
php artisan serve