@echo off
cd /d c:\laragon\www\thonburi-culture
echo Running SecurityTest...
echo.
vendor\bin\pest tests\Feature\SecurityTest.php
echo.
echo Test completed!
pause
