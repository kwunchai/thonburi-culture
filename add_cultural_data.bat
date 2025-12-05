@echo off
echo ===== เพิ่มข้อมูลวัฒนธรรม 20 รายการ =====
echo.

cd /d "c:\laragon\www\thonburi-culture"

echo 🚀 กำลังเพิ่มข้อมูลวัฒนธรรมใหม่ 20 รายการ...
echo.

php add_20_cultural_items.php

echo.
echo ===== เสร็จสิ้น =====
echo ✅ เพิ่มข้อมูลวัฒนธรรมใหม่แล้ว!
echo 🔄 รีเฟรชหน้าเว็บเพื่อดูข้อมูลใหม่
echo 🌐 http://localhost/thonburi-culture/admin/cultural-items
echo.
echo กด Enter เพื่อปิด...
pause