@echo off
echo ===== GitHub Upload Script =====
echo.

cd c:\laragon\www\thonburi-culture

echo Current directory: %CD%
echo.

echo Checking git status...
git status

echo.
echo Adding all files...
git add .

echo.
echo Committing changes...
git commit -m "feat: Complete IP management system with working detail views"

echo.
echo Checking current branch...
git branch

echo.
echo Creating new branch...
git checkout -b feature/ip-management-system-complete

echo.
echo Pushing to GitHub...
git push origin feature/ip-management-system-complete

echo.
echo ===== Upload Complete! =====
pause