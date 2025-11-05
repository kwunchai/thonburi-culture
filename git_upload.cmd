@echo off
rem Simple Git Upload Script

rem Change to project directory
cd /d "c:\laragon\www\thonburi-culture"

rem Show current status
echo === Current Git Status ===
git status --porcelain

rem Add all changes
echo === Adding Files ===
git add .

rem Commit changes
echo === Committing Changes ===
git commit -m "feat: Complete IP management system with all fixes

- Fixed view template @endsection errors
- Added custom route model binding for ip_id
- Extended IpType and IpStatus enums with new cases
- Updated controllers with show method
- Removed action buttons from detail view as requested
- Added comprehensive debugging and testing tools
- Ready for production deployment"

rem Check branches
echo === Current Branches ===
git branch -a

rem Create new feature branch
echo === Creating Feature Branch ===
git checkout -b feature/ip-system-complete-%date:~-4,4%%date:~-7,2%%date:~-10,2%

rem Push to GitHub
echo === Pushing to GitHub ===
git push origin HEAD

echo === Upload Complete ===
pause