@echo off
cd /d c:\laragon\www\thonburi-culture
echo ==========================================
echo Security Tests Suite
echo ==========================================
echo.

echo [1/2] SecurityTest (18 tests)...
vendor\bin\pest tests\Feature\SecurityTest.php --compact
echo.

echo [2/2] AdvancedSecurityTest (19 tests)...
vendor\bin\pest tests\Feature\AdvancedSecurityTest.php --compact
echo.

echo ==========================================
echo Total: 37 Security Tests
echo ==========================================
pause
