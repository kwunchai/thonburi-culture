# Merge to Main Branch - PowerShell
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Merge to Main Branch" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

Set-Location "c:\laragon\www\thonburi-culture"

Write-Host "[1/8] Current branch status..." -ForegroundColor Yellow
git branch
Write-Host ""

Write-Host "[2/8] Fetching latest from origin..." -ForegroundColor Yellow
git fetch origin
Write-Host ""

Write-Host "[3/8] Switching to main branch..." -ForegroundColor Yellow
git checkout main
Write-Host ""

Write-Host "[4/8] Pulling latest main..." -ForegroundColor Yellow
git pull origin main
Write-Host ""

Write-Host "[5/8] Merging final-05-12-2025 into main..." -ForegroundColor Yellow
git merge final-05-12-2025 -m "Merge: Complete test suite with 273 tests (Phase 1-5A + Advanced Security)"
Write-Host ""

Write-Host "[6/8] Pushing to main..." -ForegroundColor Yellow
git push origin main
Write-Host ""

Write-Host "[7/8] Setting main as default branch..." -ForegroundColor Yellow
Write-Host "Go to: https://github.com/kwunchai/thonburi-culture/settings/branches" -ForegroundColor White
Write-Host ""

Write-Host "[8/8] Cleaning up old branches (optional)..." -ForegroundColor Yellow
Write-Host "To delete local branch: git branch -d final-05-12-2025" -ForegroundColor Gray
Write-Host "To delete remote: git push origin --delete final-05-12-2025" -ForegroundColor Gray
Write-Host ""

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Merge Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Main branch now has all 273 tests" -ForegroundColor White
Write-Host "Branch: final-05-12-2025 merged" -ForegroundColor White
Write-Host ""

Read-Host -Prompt "Press Enter to continue"
