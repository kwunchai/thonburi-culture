@echo off
title Thonburi Culture - Conflict Resolution Test

echo ========================================
echo    Thonburi Culture Conflict Test      
echo         Thai Cultural Heritage          
echo         IP Management System            
echo ========================================
echo.

cd /d "c:\laragon\www\thonburi-culture"

echo [1] Running comprehensive conflict check...
php fix_all_conflicts.php

echo.
echo [2] Running specific IP tests...
if exist "tests/Feature/IntellectualPropertyTest.php" (
    echo Testing IP functionality...
    vendor\bin\pest tests/Feature/IntellectualPropertyTest.php --verbose
) else (
    echo ⚠️  IP test file not found
)

echo.
echo [3] Checking route conflicts...
php artisan route:list | findstr /i "ip\|intellectual\|cultural"

echo.
echo [4] Testing model relationships...
php -r "
require 'vendor/autoload.php';
try {
    if (class_exists('App\Models\IntellectualProperty')) {
        echo 'IP Model: ✓ Available' . PHP_EOL;
        $ip = new App\Models\IntellectualProperty();
        echo 'Route Key: ' . $ip->getRouteKeyName() . PHP_EOL;
    }
    if (class_exists('App\Models\CulturalItem')) {
        echo 'Cultural Model: ✓ Available' . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
"

echo.
echo [5] Checking view files...
dir "resources\views\admin\intellectual-property" /b 2>nul || echo ⚠️  IP admin views missing
dir "resources\views\frontend\ip" /b 2>nul || echo ⚠️  IP frontend views missing

echo.
echo [6] Testing database structure...
php artisan migrate:status

echo.
echo [7] Checking enum definitions...
php -r "
require 'vendor/autoload.php';
try {
    if (enum_exists('App\Enums\IpType')) {
        echo 'IpType Enum: ✓ Available' . PHP_EOL;
        foreach (App\Enums\IpType::cases() as $case) {
            echo '  - ' . $case->name . ' => ' . $case->label() . PHP_EOL;
        }
    }
    if (enum_exists('App\Enums\IpStatus')) {
        echo 'IpStatus Enum: ✓ Available' . PHP_EOL;
        foreach (App\Enums\IpStatus::cases() as $case) {
            echo '  - ' . $case->name . ' => ' . $case->label() . PHP_EOL;
        }
    }
} catch (Exception $e) {
    echo 'Enum Error: ' . $e->getMessage() . PHP_EOL;
}
"

echo.
echo ========================================
echo           Test Complete!                
echo ========================================
echo.
echo Check conflict_report.json for details
echo.
pause