@echo off
cd /d c:\laragon\www\thonburi-culture
echo Running Phase 4 Tests...
echo.

echo [1/4] IpFileUploadTest...
vendor\bin\pest tests\Feature\IpFileUploadTest.php --compact
echo.

echo [2/4] EmailNotificationTest...
vendor\bin\pest tests\Feature\EmailNotificationTest.php --compact
echo.

echo [3/4] DatabaseIntegrityTest...
vendor\bin\pest tests\Feature\DatabaseIntegrityTest.php --compact
echo.

echo [4/4] SecurityTest...
vendor\bin\pest tests\Feature\SecurityTest.php --compact
echo.

echo Phase 4 Tests Completed!
pause
