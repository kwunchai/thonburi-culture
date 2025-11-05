Write-Host "=== Git Deployment Script ===" -ForegroundColor Green

Set-Location "c:\laragon\www\thonburi-culture"

Write-Host "Current directory: $(Get-Location)" -ForegroundColor Yellow

Write-Host "Checking git status..." -ForegroundColor Cyan
git status --short

Write-Host "Adding all files..." -ForegroundColor Cyan
git add .

Write-Host "Committing changes..." -ForegroundColor Cyan
git commit -m "feat: Complete IP management system

✅ Fixed view template @endsection error
✅ Added custom route model binding  
✅ Extended IpType and IpStatus enums
✅ Updated controllers and views
✅ Removed action buttons as requested
✅ Added comprehensive debugging tools
✅ Ready for production use"

Write-Host "Creating and pushing branch..." -ForegroundColor Cyan
git checkout -b "feature/ip-management-complete-$(Get-Date -Format 'yyyyMMdd-HHmm')"
git push origin HEAD

Write-Host "=== Deployment Complete! ===" -ForegroundColor Green