@echo off
echo ========================================
echo Git Upload - Thonburi Culture Tests
echo ========================================
echo.

cd /d c:\laragon\www\thonburi-culture

echo [1/6] Checking git status...
git status
echo.

echo [2/6] Adding all files...
git add .
echo.

echo [3/6] Committing changes...
git commit -m "Add comprehensive test suite - 273 tests (Phase 1-5A + Security)"
echo.

echo [4/6] Creating new branch: final-05-12-2025...
git checkout -b final-05-12-2025
echo.

echo [5/6] Pushing to GitHub...
git push -u origin final-05-12-2025
echo.

echo [6/6] Upload complete!
echo.
echo ========================================
echo Next steps:
echo 1. Go to GitHub repository
echo 2. Create Pull Request
echo 3. Merge to main branch
echo ========================================
pause
