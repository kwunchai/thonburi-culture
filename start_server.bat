@echo off
title Thonburi Culture - Start Server

echo ========================================
echo      เริ่มเซิร์ฟเวอร์ วัฒนธรรมธนบุรี       
echo           Laravel Development           
echo ========================================
echo.

cd /d "c:\laragon\www\thonburi-culture"

echo [1] ตรวจสอบ Storage Link...
php artisan storage:link

echo.
echo [2] ล้าง Cache...
php artisan config:clear
php artisan cache:clear

echo.
echo [3] เริ่มเซิร์ฟเวอร์...
echo.
echo 🌐 เว็บไซต์จะเปิดที่: http://localhost:8000
echo 📋 หน้าสำรวจ: http://localhost:8000/explore
echo 🖼️ ทดสอบรูป: http://localhost:8000/test-images.html
echo.
echo กด Ctrl+C เพื่อหยุดเซิร์ฟเวอร์
echo.

php artisan serve --host=0.0.0.0 --port=8000