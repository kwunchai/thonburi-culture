@echo off
echo Reconfiguring Xdebug for Coverage...

REM ลบการกำหนดค่า Xdebug เก่าออกจาก php.ini
powershell -Command "(Get-Content 'C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini') | Where-Object { $_ -notmatch 'xdebug' -and $_ -notmatch '^\[xdebug\]' } | Set-Content 'C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini'"

REM เพิ่มการกำหนดค่า Xdebug ใหม่
echo. >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo [xdebug] >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo zend_extension=php_xdebug.dll >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo xdebug.mode=coverage >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo xdebug.start_with_request=yes >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"

echo Xdebug reconfigured successfully!
echo.
echo Testing PHP modules...
php -m | findstr -i xdebug

echo.
echo If Xdebug appears above, you can now run:
echo php artisan test --coverage
pause