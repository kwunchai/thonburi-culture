# Phase 4 Test Runner
Set-Location "c:\laragon\www\thonburi-culture"

Write-Host "Running Phase 4 Tests..." -ForegroundColor Cyan
Write-Host ""

Write-Host "[1/4] IpFileUploadTest..." -ForegroundColor Yellow
& vendor\bin\pest tests\Feature\IpFileUploadTest.php --compact
Write-Host ""

Write-Host "[2/4] EmailNotificationTest..." -ForegroundColor Yellow
& vendor\bin\pest tests\Feature\EmailNotificationTest.php --compact
Write-Host ""

Write-Host "[3/4] DatabaseIntegrityTest..." -ForegroundColor Yellow
& vendor\bin\pest tests\Feature\DatabaseIntegrityTest.php --compact
Write-Host ""

Write-Host "[4/4] SecurityTest..." -ForegroundColor Yellow
& vendor\bin\pest tests\Feature\SecurityTest.php --compact
Write-Host ""

Write-Host "Phase 4 Tests Completed!" -ForegroundColor Green
