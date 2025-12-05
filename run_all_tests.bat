@echo off
cd /d c:\laragon\www\thonburi-culture
echo Running Full Test Suite...
vendor\bin\pest --compact > test_output.txt 2>&1
echo Tests completed. Check test_output.txt for results.
type test_output.txt
pause
