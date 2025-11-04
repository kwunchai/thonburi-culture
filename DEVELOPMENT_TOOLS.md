# 🔧 Thonburi Culture - IntellectualProperty Development Tools

## 📋 Overview
เครื่องมือสำหรับช่วยในการพัฒนาและทดสอบระบบจัดการทรัพย์สินทางปัญญา (IntellectualProperty Management System)

## 🛠️ Development Scripts

### 1. **test_coverage.bat** - Coverage Testing Tool
รันการทดสอบ code coverage สำหรับ IntellectualProperty tests

```bash
# วิธีใช้งาน
.\test_coverage.bat
```

**คุณสมบัติ:**
- ทดสอบ IntellectualPropertyTest ทั้ง 11 test cases
- แสดง code coverage report แบบละเอียด
- ใช้ Xdebug สำหรับ coverage analysis
- One-click execution

### 2. **reconfigure_xdebug.bat** - Xdebug Configuration Tool
ตั้งค่า Xdebug ในไฟล์ php.ini อัตโนมัติ

```bash
# วิธีใช้งาน
.\reconfigure_xdebug.bat
```

**คุณสมบัติ:**
- ลบการกำหนดค่า Xdebug เก่าออกจาก php.ini
- เพิ่มการกำหนดค่า Xdebug ใหม่สำหรับ coverage
- ทดสอบว่า Xdebug โหลดสำเร็จหรือไม่
- รองรับ PHP 8.3 บน Laragon

### 3. **install_xdebug.bat** - Xdebug Installation Tool
ดาวน์โหลดและติดตั้ง Xdebug extension

```bash
# วิธีใช้งาน
.\install_xdebug.bat
```

**คุณสมบัติ:**
- ดาวน์โหลด Xdebug 3.3.1 สำหรับ PHP 8.3
- ติดตั้งไปยัง extensions directory
- รองรับ Windows x64 architecture

### 4. **fix_xdebug_path.bat** - Xdebug Path Fixer
แก้ไขปัญหา path ของ Xdebug extension

```bash
# วิธีใช้งาน
.\fix_xdebug_path.bat
```

**คุณสมบัติ:**
- ใช้ full path สำหรับ zend_extension
- แก้ไขปัญหา Xdebug ไม่โหลด
- Backup ไฟล์ php.ini เดิม

### 5. **configure_xdebug.bat** - Basic Xdebug Setup
การตั้งค่า Xdebug พื้นฐาน

```bash
# วิธีใช้งาน
.\configure_xdebug.bat
```

## 📊 Testing Results

### ✅ Test Coverage Metrics
```
Tests:    11 passed (56 assertions)
Duration: 5.40s

Coverage Results:
- IntellectualPropertyController (API): 58.8%
- IntellectualPropertyResource: 88.7%
- IntellectualPropertyPolicy: 71.4%
- StoreIntellectualPropertyRequest: 98.7%
- UpdateIntellectualPropertyRequest: 100%
```

### 🧪 Test Cases Covered
1. ✅ it can list intellectual properties
2. ✅ it can create intellectual property
3. ✅ it validates required fields
4. ✅ it validates unique title
5. ✅ it can show single intellectual property
6. ✅ it can update intellectual property
7. ✅ it prevents unauthorized updates
8. ✅ it can delete intellectual property
9. ✅ it can filter by type
10. ✅ it can search intellectual properties
11. ✅ it can upload attachments

## 🔧 System Requirements

- **PHP**: 8.3.16+ (Laragon)
- **Xdebug**: 3.3.1+ 
- **Laravel**: 11.x
- **Pest**: Latest version
- **OS**: Windows (batch scripts)

## 📁 Project Structure

```
thonburi-culture/
├── app/
│   ├── Http/Controllers/Api/
│   │   └── IntellectualPropertyController.php
│   ├── Models/
│   │   └── IntellectualProperty.php
│   ├── Policies/
│   │   └── IntellectualPropertyPolicy.php
│   └── Http/Resources/
│       └── IntellectualPropertyResource.php
├── tests/Feature/
│   └── IntellectualPropertyTest.php
├── test_coverage.bat              # ← Coverage Testing Tool
├── reconfigure_xdebug.bat         # ← Xdebug Configuration
├── install_xdebug.bat             # ← Xdebug Installation
├── fix_xdebug_path.bat           # ← Path Fixer
└── configure_xdebug.bat          # ← Basic Setup
```

## 🚀 Quick Start

1. **ติดตั้ง Xdebug** (ครั้งแรกเท่านั้น):
   ```bash
   .\install_xdebug.bat
   ```

2. **ตั้งค่า Xdebug**:
   ```bash
   .\reconfigure_xdebug.bat
   ```

3. **รันการทดสอบ Coverage**:
   ```bash
   .\test_coverage.bat
   ```

## 🐛 Troubleshooting

### ปัญหา: Xdebug ไม่โหลด
**วิธีแก้:**
```bash
.\fix_xdebug_path.bat
```

### ปัญหา: Coverage driver not available
**วิธีแก้:**
ใช้คำสั่งแบบเต็ม:
```bash
php -d "zend_extension=C:\laragon\bin\php\php-8.3.16-Win32-vs16-x64\ext\php_xdebug.dll" -d "xdebug.mode=coverage" vendor/bin/pest --coverage --filter IntellectualPropertyTest
```

### ปัญหา: Tests ไม่ผ่าน
**วิธีแก้:**
1. ตรวจสอบ database connection
2. รัน migration: `php artisan migrate:fresh`
3. ตรวจสอบ Sanctum configuration

## 📝 Notes

- Scripts เหล่านี้ออกแบบสำหรับ Windows และ Laragon โดยเฉพาะ
- ต้องรัน scripts ใน project root directory
- Xdebug จะส่งผลต่อประสิทธิภาพ ควรปิดในการใช้งาน production
- Coverage report จะแสดงใน terminal โดยตรง

---

**สร้างโดย:** Thonburi Culture Development Team  
**อัพเดตล่าสุด:** October 29, 2025  
**เวอร์ชัน:** 1.0.0