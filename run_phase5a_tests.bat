@echo off
cd /d c:\laragon\www\thonburi-culture
echo ====================================
echo Phase 5A: Admin Feature Tests
echo ====================================
echo.

echo [1/4] AdminBulkActionsTest (11 tests)...
vendor\bin\pest tests\Feature\AdminBulkActionsTest.php --compact
echo.

echo [2/4] AdminExportTest (10 tests)...
vendor\bin\pest tests\Feature\AdminExportTest.php --compact
echo.

echo [3/4] AdminImageUploadTest (10 tests)...
vendor\bin\pest tests\Feature\AdminImageUploadTest.php --compact
echo.

echo [4/4] AdminToggleActionsTest (8 tests)...
vendor\bin\pest tests\Feature\AdminToggleActionsTest.php --compact
echo.

echo ====================================
echo Phase 5A Complete!
echo Total: 39 new tests
echo ====================================
pause
