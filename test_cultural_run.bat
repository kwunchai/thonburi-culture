@echo off
echo ===== ทดสอบการเพิ่มข้อมูลวัฒนธรรม =====
echo.

cd /d "c:\laragon\www\thonburi-culture"

echo 🔄 กำลังรันสคริปต์ทดสอบ...
echo.

php simple_test.php

echo.
echo ===== เสร็จสิ้น =====
echo ให้เข้าไปดูที่:
echo 1. Login: http://localhost/thonburi-culture/login
echo 2. Email: admin@thonburi.com
echo 3. Password: password
echo 4. หลัง login แล้วไปที่เมนู "ข้อมูลวัฒนธรรม"
echo.
echo กด Enter เพื่อปิด...
pause