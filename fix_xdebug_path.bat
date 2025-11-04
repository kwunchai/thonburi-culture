@echo off
echo Fixing Xdebug Path Configuration...

REM สำรองไฟล์
copy "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini" "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini.backup2"

REM ลบการกำหนดค่า Xdebug เก่า
powershell -Command "(Get-Content 'C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini') | Where-Object { $_ -notmatch 'xdebug' } | Set-Content 'C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini'"

REM เพิ่มการกำหนดค่า Xdebug ใหม่
echo. >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo [xdebug] >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo zend_extension="C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\ext\php_xdebug.dll" >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo xdebug.mode=coverage,develop >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"
echo xdebug.start_with_request=yes >> "C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\php.ini"

echo Xdebug path configuration updated with full path!
pause