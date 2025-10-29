@echo off
echo Configuring Xdebug for Coverage in main php.ini...

:: Backup original php.ini
copy "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini" "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini.backup"

:: Add Xdebug configuration to main php.ini
echo. >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo [xdebug] >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo zend_extension=php_xdebug.dll >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo xdebug.mode=coverage,develop >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo xdebug.start_with_request=yes >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"

echo Xdebug configuration added to main php.ini
echo Please restart Laragon for changes to take effect.
echo.
echo After restart, you can run:
echo php artisan test --coverage --filter IntellectualPropertyTest
pause