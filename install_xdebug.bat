@echo off
echo Installing Xdebug for PHP 8.3...

:: Create downloads directory if not exists
if not exist "C:\laragon\temp" mkdir "C:\laragon\temp"

:: Download Xdebug for PHP 8.3 (TS x64)
echo Downloading Xdebug...
powershell -Command "Invoke-WebRequest -Uri 'https://xdebug.org/files/php_xdebug-3.3.1-8.3-vs16-x86_64.dll' -OutFile 'C:\laragon\temp\php_xdebug.dll'"

:: Copy to extensions directory
echo Installing Xdebug...
copy "C:\laragon\temp\php_xdebug.dll" "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\ext\php_xdebug.dll"

echo Xdebug downloaded. Please add the following line to your php.ini:
echo zend_extension=php_xdebug.dll
echo.
echo Then restart Laragon.
pause