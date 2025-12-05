@echo off
cd /d c:\laragon\www\thonburi-culture

echo Running Phase 4 Tests... > phase4_results.txt
echo. >> phase4_results.txt

echo [1/4] IpFileUploadTest >> phase4_results.txt
vendor\bin\pest tests\Feature\IpFileUploadTest.php --compact >> phase4_results.txt 2>&1
echo. >> phase4_results.txt

echo [2/4] EmailNotificationTest >> phase4_results.txt
vendor\bin\pest tests\Feature\EmailNotificationTest.php --compact >> phase4_results.txt 2>&1
echo. >> phase4_results.txt

echo [3/4] DatabaseIntegrityTest >> phase4_results.txt
vendor\bin\pest tests\Feature\DatabaseIntegrityTest.php --compact >> phase4_results.txt 2>&1
echo. >> phase4_results.txt

echo [4/4] SecurityTest >> phase4_results.txt
vendor\bin\pest tests\Feature\SecurityTest.php --compact >> phase4_results.txt 2>&1
echo. >> phase4_results.txt

echo Tests completed. Results saved to phase4_results.txt
type phase4_results.txt
