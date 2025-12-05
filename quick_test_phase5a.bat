@echo off
cd /d c:\laragon\www\thonburi-culture
echo Running Phase 5A Tests...
echo.
vendor\bin\pest tests\Feature\AdminBulkActionsTest.php tests\Feature\AdminExportTest.php tests\Feature\AdminImageUploadTest.php tests\Feature\AdminToggleActionsTest.php --compact > phase5a_results.txt 2>&1
echo.
echo Results saved to phase5a_results.txt
type phase5a_results.txt
pause
