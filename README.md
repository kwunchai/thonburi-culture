# ระบบฐานข้อมูลมรดกทางวัฒนธรรมธนบุรี
# Thonburi Cultural Heritage Database

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat&logo=php)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

ระบบจัดการข้อมูลมรดกทางวัฒนธรรมและทรัพย์สินทางปัญญาของชุมชนธนบุรี พัฒนาด้วย Laravel 12 เพื่อการอนุรักษ์และเผยแพร่มรดกทางวัฒนธรรมไทย

A comprehensive cultural heritage and intellectual property management system for Thonburi communities. Built with Laravel 12 for preserving and promoting Thai cultural heritage.

## 📋 เกี่ยวกับระบบ | About

ระบบฐานข้อมูลมรดกทางวัฒนธรรมธนบุรีเป็นแพลตฟอร์มการจัดการข้อมูลทางวัฒนธรรมแบบครบวงจร ที่รวมเอาการจัดการมรดกทางวัฒนธรรมและทรัพย์สินทางปัญญาเข้าด้วยกัน เหมาะสำหรับหน่วยงานราชการ องค์กรวัฒนธรรม และชุมชนท้องถิ่น

The Thonburi Cultural Heritage Database is a comprehensive platform integrating cultural heritage management and intellectual property administration. Designed for government agencies, cultural organizations, and local communities.

### ✨ ฟีเจอร์หลัก | Key Features

#### 📚 การจัดการมรดกทางวัฒนธรรม | Cultural Heritage Management
- **รายการวัตถุทางวัฒนธรรม** - จัดเก็บและจัดหมวดหมู่วัตถุทางวัฒนธรรม
- **ข้อมูลชุมชน** - บริหารจัดการข้อมูลชุมชนและที่ตั้ง
- **กิจกรรมทางวัฒนธรรม** - ติดตามและประชาสัมพันธ์กิจกรรม
- **Google Maps Integration** - แสดงตำแหน่งที่ตั้งบนแผนที่
- **ระบบแกลเลอรีรูปภาพ** - จัดเก็บและแสดงภาพถ่ายมรดกทางวัฒนธรรม

#### ⚖️ การจัดการทรัพย์สินทางปัญญา | Intellectual Property Management
- **11 ประเภททรัพย์สินทางปัญญา** - สิทธิบัตร, ลิขสิทธิ์, เครื่องหมายการค้า, และอื่นๆ
- **ระบบอนุมัติ 7 สถานะ** - Draft → Pending → Registered → Active → Expired
- **Excel Import/Export** - นำเข้าและส่งออกข้อมูล IP
- **การจัดการเอกสาร** - แนบและจัดเก็บไฟล์เอกสาร
- **ติดตามวันหมดอายุ** - แจ้งเตือนอัตโนมัติ

#### 🔐 ระบบควบคุมการเข้าถึง | Access Control
- **บทบาท 3 ระดับ** - Admin, IP Manager, User
- **Policy-Based Authorization** - ควบคุมการเข้าถึงแบบละเอียด
- **Laravel Breeze Authentication** - ระบบยืนยันตัวตนที่ปลอดภัย

#### 🎨 ส่วนติดต่อผู้ใช้ | User Interface
- **Frontend สาธารณะ** - หน้าเว็บสำหรับประชาชนทั่วไป
- **Admin Dashboard** - AdminLTE 3.x สำหรับผู้ดูแลระบบ
- **Responsive Design** - Tailwind CSS 3.x พร้อมธีมสีธนบุรี
- **ภาษาไทย/อังกฤษ** - รองรับสองภาษา

## 🛠️ เทคโนโลยี | Technology Stack

### Backend
- **Laravel 12.x** - PHP Framework
- **PHP 8.3+** - Programming Language
- **MySQL/MariaDB** - Database (Production)
- **SQLite** - Database (Development/Testing)

### Frontend
- **Blade Templates** - Server-side Rendering
- **Tailwind CSS 3.x** - Utility-first CSS Framework
- **Alpine.js** - Lightweight JavaScript Framework
- **Vite** - Frontend Build Tool
- **AdminLTE 3.x** - Admin Dashboard Theme

### Additional Libraries
- **Laravel Sanctum** - API Authentication
- **Maatwebsite Excel** - Excel Import/Export
- **Google Maps API** - Geolocation Services
- **Pest PHP** - Testing Framework (273 tests)

## 📦 ความต้องการระบบ | Requirements

- **PHP**: >= 8.3
- **Composer**: >= 2.0
- **Node.js**: >= 18.x
- **NPM**: >= 9.x
- **Database**: MySQL >= 8.0 / MariaDB >= 10.3 / SQLite 3
- **Web Server**: Apache / Nginx

### PHP Extensions Required
```
BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, 
PDO, PDO_MySQL, Tokenizer, XML, GD/Imagick
```

## 🚀 การติดตั้ง | Installation

### 1. Clone Repository
```bash
git clone https://github.com/kwunchai/thonburi-culture.git
cd thonburi-culture
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=thonburi_culture
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Configure Google Maps API (optional)
GOOGLE_MAPS_API_KEY=your_google_maps_api_key
```

### 4. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE thonburi_culture CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;

# Run migrations
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

### 5. Storage Setup
```bash
# Create storage symlink
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### 6. Build Frontend Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start Development Server
```bash
# Option 1: Laravel Artisan
php artisan serve
# Access: http://localhost:8000

# Option 2: Using composer script (includes queue & logs)
composer run dev

# Option 3: Laragon/XAMPP/MAMP
# Configure virtual host to point to /public directory
```

## 👤 การสร้างผู้ใช้งาน | User Management

### Create Admin User
```bash
php artisan tinker
```
```php
App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'email_verified_at' => now()
]);
```

### Create IP Manager
```bash
php artisan tinker
```
```php
App\Models\User::create([
    'name' => 'IP Manager',
    'email' => 'ipmanager@example.com',
    'password' => bcrypt('password'),
    'role' => 'ip_manager',
    'email_verified_at' => now()
]);
```

## 🗺️ โครงสร้างโปรเจ็ต | Project Structure

```
thonburi-culture/
├── app/
│   ├── Console/          # Artisan commands
│   ├── Enums/            # IpType, IpStatus enums
│   ├── Http/
│   │   ├── Controllers/  # Request handlers
│   │   │   ├── Admin/    # Admin dashboard controllers
│   │   │   ├── Api/      # API controllers
│   │   │   └── Auth/     # Authentication controllers
│   │   ├── Middleware/   # Custom middleware
│   │   └── Requests/     # Form request validation
│   ├── Models/           # Eloquent models
│   ├── Policies/         # Authorization policies
│   └── Services/         # Business logic services
├── config/               # Configuration files
│   └── maps.php          # Google Maps configuration
├── database/
│   ├── factories/        # Model factories
│   ├── migrations/       # Database migrations
│   └── seeders/          # Database seeders
├── public/               # Public web directory
│   └── build/            # Compiled frontend assets
├── resources/
│   ├── css/              # CSS source files
│   ├── js/               # JavaScript source files
│   └── views/            # Blade templates
│       ├── admin/        # Admin dashboard views
│       ├── auth/         # Authentication views
│       └── frontend/     # Public frontend views
├── routes/
│   ├── web.php           # Web routes
│   ├── api.php           # API routes
│   └── console.php       # Console commands
├── storage/              # Application storage
└── tests/                # Pest PHP tests (273 tests)
```

## 🧪 การทดสอบ | Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage (requires Xdebug)
php artisan test --coverage

# Pest PHP (alternative)
vendor/bin/pest
vendor/bin/pest --coverage
```

### Test Coverage
- **273 Total Tests**
- Feature tests for all major modules
- Policy and authorization tests
- Security tests (OWASP compliance)
- Integration tests with database

## 📱 การเข้าถึงระบบ | System Access

### Public Frontend
```
http://localhost:8000/
```
- Homepage with cultural statistics
- Cultural items gallery
- Community information
- Activity calendar
- Public IP registry

### Admin Dashboard
```
http://localhost:8000/login
```
**Default Credentials** (if seeded):
- Email: `admin@example.com`
- Password: `password`

**Admin Features:**
- Cultural item management
- Community management
- Activity management
- IP management
- User management
- System settings

## 🔧 คำสั่งที่สำคัญ | Important Commands

### Development
```bash
# Clear all caches
php artisan optimize:clear

# Rebuild caches
php artisan optimize

# Clear specific caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# View application info
php artisan about

# Run database migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration with seed
php artisan migrate:fresh --seed
```

### Production Deployment
```bash
# Build frontend assets
npm run build

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations
php artisan migrate --force

# Link storage
php artisan storage:link
```

## 🌐 API Endpoints

### Cultural Items
```
GET    /api/cultural-items       # List all items
GET    /api/cultural-items/{id}  # Show item details
POST   /api/cultural-items       # Create item (auth)
PUT    /api/cultural-items/{id}  # Update item (auth)
DELETE /api/cultural-items/{id}  # Delete item (auth)
```

### Intellectual Property
```
GET    /api/intellectual-property       # List all IPs
GET    /api/intellectual-property/{id}  # Show IP details
POST   /api/intellectual-property       # Create IP (auth)
PUT    /api/intellectual-property/{id}  # Update IP (auth)
DELETE /api/intellectual-property/{id}  # Delete IP (auth)
```

**Authentication**: Bearer Token (Laravel Sanctum)

## 📊 ฐานข้อมูล | Database Schema

### Key Tables
- `cultural_items` - วัตถุทางวัฒนธรรม
- `cultural_categories` - หมวดหมู่วัฒนธรรม
- `communities` - ข้อมูลชุมชน
- `activities` - กิจกรรมทางวัฒนธรรม
- `activity_categories` - หมวดหมู่กิจกรรม
- `intellectual_properties` - ทรัพย์สินทางปัญญา (uses `ip_id` as primary key)
- `users` - ผู้ใช้งานระบบ

### Enums
- **IpType**: Patent, Copyright, Trademark, Trade Secret, Industrial Design, Plant Variety, Geographical Indication, Layout Design, Utility Model, Traditional Knowledge, Cultural Expression
- **IpStatus**: Draft, Pending, Under Review, Approved, Registered, Active, Expired

## 🎨 การปรับแต่งธีม | Theme Customization

### Tailwind Custom Colors (Thonburi Theme)
```javascript
// tailwind.config.js
colors: {
  'thonburi-gold': {
    50: '#fffbeb',
    500: '#d4af37',
    900: '#806520',
  },
  'thonburi-navy': {
    50: '#f0f9ff',
    500: '#1e3a8a',
    900: '#0c1e4a',
  },
  'thonburi-river': {
    50: '#f0f9ff',
    500: '#0ea5e9',
    900: '#075985',
  }
}
```

## 🔐 ความปลอดภัย | Security

- **Authentication**: Laravel Breeze with email verification
- **Authorization**: Policy-based access control
- **CSRF Protection**: Enabled on all forms
- **SQL Injection**: Protected via Eloquent ORM
- **XSS Protection**: Blade template escaping
- **Password Hashing**: Bcrypt with rounds=12
- **HTTPS**: Recommended for production
- **Rate Limiting**: API throttling enabled

## 🤝 การมีส่วนร่วม | Contributing

เรายินดีรับการมีส่วนร่วมจากทุกท่าน กรุณาปฏิบัติตามขั้นตอนดังนี้:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use Thai language for UI text
- Maintain bilingual comments (Thai/English)

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 ผู้พัฒนา | Developer

**Thonburi Cultural Heritage Development Team**

## 📧 ติดต่อ | Contact

สำหรับข้อสงสัยหรือข้อเสนอแนะ กรุณาติดต่อ:
- GitHub Issues: [https://github.com/kwunchai/thonburi-culture/issues](https://github.com/kwunchai/thonburi-culture/issues)
- Email: admin@example.com

## 🙏 ขอบคุณ | Acknowledgments

- Laravel Framework - Taylor Otwell
- AdminLTE - ColorlibHQ
- Tailwind CSS - Tailwind Labs
- Thai Cultural Heritage Community
- All contributors and supporters

---

**พัฒนาเพื่อการอนุรักษ์และเผยแพร่มรดกทางวัฒนธรรมไทย**

**Developed for the preservation and promotion of Thai cultural heritage**
# thonburi-culture
# thonburi-culture
