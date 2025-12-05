@echo off
echo ====================================
echo Phase 4 Test Summary
echo ====================================
echo.

cd /d c:\laragon\www\thonburi-culture

echo [1/4] Running IpFileUploadTest...
vendor\bin\pest tests\Feature\IpFileUploadTest.php --compact 2>&1 | findstr /C:"Tests:" /C:"passed" /C:"failed" /C:"PASS" /C:"FAIL"
echo.

echo [2/4] Running EmailNotificationTest...
vendor\bin\pest tests\Feature\EmailNotificationTest.php --compact 2>&1 | findstr /C:"Tests:" /C:"passed" /C:"failed" /C:"PASS" /C:"FAIL"
echo.

echo [3/4] Running DatabaseIntegrityTest...
vendor\bin\pest tests\Feature\DatabaseIntegrityTest.php --compact 2>&1 | findstr /C:"Tests:" /C:"passed" /C:"failed" /C:"PASS" /C:"FAIL"
echo.

echo [4/4] Running SecurityTest...
vendor\bin\pest tests\Feature\SecurityTest.php --compact 2>&1 | findstr /C:"Tests:" /C:"passed" /C:"failed" /C:"PASS" /C:"FAIL"
echo.

echo ====================================
echo Phase 4 Tests Complete
echo ====================================
