# Git Upload Script for PowerShell
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Git Upload - Thonburi Culture Tests" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

Set-Location "c:\laragon\www\thonburi-culture"

Write-Host "[1/6] Checking git status..." -ForegroundColor Yellow
git status
Write-Host ""

Write-Host "[2/6] Adding all files..." -ForegroundColor Yellow
git add .
Write-Host ""

Write-Host "[3/6] Committing changes..." -ForegroundColor Yellow
git commit -m "Add comprehensive test suite - 273 tests (Phase 1-5A + Security)"
Write-Host ""

Write-Host "[4/6] Creating new branch: final-05-12-2025..." -ForegroundColor Yellow
git checkout -b final-05-12-2025
Write-Host ""

Write-Host "[5/6] Pushing to GitHub..." -ForegroundColor Yellow
git push -u origin final-05-12-2025
Write-Host ""

Write-Host "[6/6] Upload complete!" -ForegroundColor Green
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Next steps:" -ForegroundColor White
Write-Host "1. Go to GitHub repository" -ForegroundColor White
Write-Host "2. Create Pull Request" -ForegroundColor White
Write-Host "3. Merge to main branch" -ForegroundColor White
Write-Host "========================================" -ForegroundColor Cyan

Read-Host -Prompt "Press Enter to continue"
