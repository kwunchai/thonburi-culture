@echo off
cd c:\laragon\www\thonburi-culture
echo Current branch:
git branch
echo.
echo Committing changes:
git add .
git commit -m "feat: Complete IP management system with working views - Fixed view template errors - Added route model binding - Updated enums and controllers - Removed action buttons as requested - Ready for production"
echo.
echo Pushing to GitHub:
git push origin feature/ip-management-complete
echo.
echo Done!
pause