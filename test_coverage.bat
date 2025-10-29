@echo off
echo Running IntellectualProperty Tests with Coverage...
echo.

php -d "zend_extension=C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\ext\php_xdebug.dll" -d "xdebug.mode=coverage" vendor/bin/pest --coverage --filter IntellectualPropertyTest

echo.
echo Coverage testing completed!
pause