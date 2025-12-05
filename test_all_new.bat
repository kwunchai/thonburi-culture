@echo off
cd /d c:\laragon\www\thonburi-culture
echo Testing All Suites...
echo.

echo Phase 4 Tests (65 tests)...
vendor\bin\pest tests\Feature\IpFileUploadTest.php tests\Feature\EmailNotificationTest.php tests\Feature\DatabaseIntegrityTest.php tests\Feature\SecurityTest.php --compact > test_results.txt 2>&1

echo.
echo Phase 5A Tests (38 tests)...
vendor\bin\pest tests\Feature\AdminBulkActionsTest.php tests\Feature\AdminExportTest.php tests\Feature\AdminImageUploadTest.php tests\Feature\AdminToggleActionsTest.php --compact >> test_results.txt 2>&1

echo.
echo Advanced Security Tests (19 tests)...
vendor\bin\pest tests\Feature\AdvancedSecurityTest.php --compact >> test_results.txt 2>&1

echo.
echo Results saved to test_results.txt
type test_results.txt
