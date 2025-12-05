@echo off
echo ========================================
echo Merge to Main Branch
echo ========================================
echo.

cd /d c:\laragon\www\thonburi-culture

echo [1/8] Current branch status...
git branch
echo.

echo [2/8] Fetching latest from origin...
git fetch origin
echo.

echo [3/8] Switching to main branch...
git checkout main
echo.

echo [4/8] Pulling latest main...
git pull origin main
echo.

echo [5/8] Merging final-05-12-2025 into main...
git merge final-05-12-2025 -m "Merge: Complete test suite with 273 tests (Phase 1-5A + Advanced Security)"
echo.

echo [6/8] Pushing to main...
git push origin main
echo.

echo [7/8] Setting main as default branch (done on GitHub)...
echo Go to: https://github.com/kwunchai/thonburi-culture/settings/branches
echo.

echo [8/8] Cleaning up old branches (optional)...
echo To delete old branch: git branch -d final-05-12-2025
echo To delete remote: git push origin --delete final-05-12-2025
echo.

echo ========================================
echo Merge Complete!
echo ========================================
echo.
echo Main branch now has all 273 tests
echo Branch: final-05-12-2025 merged
echo.
pause
