# Thonburi Culture - AI Coding Agent Instructions

This is a **bilingual Thai cultural heritage management system** built with Laravel 12, featuring **dual domains**: traditional cultural items and intellectual property (IP) management. The project uses **Thai language** extensively in UI, database fields, and comments.

## 🏗️ Architecture Overview

**Core Domains:**
- **Cultural Heritage**: `CulturalItem`, `CulturalCategory`, `Community`, `Place` models with Google Maps integration
- **Intellectual Property**: `IntellectualProperty` model with comprehensive IP lifecycle management
- **Dual Frontend**: Public cultural exploration + Admin dashboard with role-based access

**Key Architectural Patterns:**
- **Custom Route Binding**: IP models use `ip_id` as primary key instead of `id` (see `IntellectualProperty::getRouteKeyName()`)
- **Enum-Driven Design**: `IpType` (11 types) and `IpStatus` (7 statuses) enums with Thai labels in `app/Enums/`
- **Service Layer**: `IntellectualPropertyService` handles complex business logic like registration workflows
- **Policy-Based Authorization**: All IP operations controlled via `IntellectualPropertyPolicy` with owner-based access
- **Maps Integration**: Google Maps API for cultural item geolocation (`config/maps.php`, Thonburi default: 13.7563, 100.5018)
- **Custom Middleware**: `AdminMiddleware`, `CheckIpPermission`, `CheckRole` for granular authorization

## 🔧 Development Workflow

**Local Development (Laragon/Windows):**
```bash
# Test with coverage (primary workflow)
.\test_coverage.bat                # Runs complete IP test suite with Xdebug coverage
                                   # Uses custom php-testing.ini with explicit Xdebug path

# Quick testing iterations  
vendor\bin\pest                    # Fast test execution without coverage
vendor\bin\pest --filter IntellectualPropertyTest
.\run_all_tests.bat               # Run complete test suite

# Database setup/reset
php artisan migrate:fresh --seed
php .\setup_cultural_data.php     # Populate cultural test data with coordinates (170 lines)
php .\check_cultural_data.php     # Verify cultural items have valid coordinates
php .\check_ip_data.php           # Verify IP data integrity and relationships

# Asset compilation
npm run dev                       # Vite dev server with hot reload
npm run build                     # Production build (required before Railway deploy)
```

**Key Testing Patterns:**
- **Pest Framework**: Primary test runner, configured in `tests/Pest.php` with `RefreshDatabase` trait
- **Feature Tests**: 38+ test files covering IP, cultural items, auth, security, search
- **Template**: `tests/Feature/IntellectualPropertyTest.php` shows best practices (281 lines)
- **API Testing**: All IP endpoints tested with JSON assertions and status codes
- **Factory Pattern**: Use `IntellectualProperty::factory()` and `CulturalItem::factory()`
- **Gate Bypassing**: Use `Gate::define()` in `setUp()` for policy testing
- **Coverage Target**: >70% on core IP functionality via Xdebug coverage mode

**Google Maps Development:**
```bash
php .\test_google_maps.php        # Verify API key and coordinate storage
php .\check_cultural_data.php     # Debug coordinate-related issues (decimal 10,8 and 11,8)
```

**Common Development Commands:**
```bash
.\reconfigure_xdebug.bat          # Fix Xdebug path issues for coverage testing
php .\create_admin.php            # Create admin user for testing
php .\create_ip_manager.php       # Create IP manager role user
.\clear_cache.bat                 # Clear all Laravel caches
.\build_css.bat                   # Rebuild Tailwind CSS
```

## 🧩 Key Conventions

**Database Schema:**
- **IP table**: Uses `ip_id` as primary key (not `id`) - critical for route binding
- **Enum columns**: `type` (IpType with 11 values), `status` (IpStatus with 7 values)  
- **Polymorphic ownership**: `owner_id` + `owner_type` (user/organization)
- **JSON columns**: `metadata` (flexible additional data), `attachments` (file paths array)
- **Soft deletes**: All major tables support soft deletion
- **Fulltext search**: MySQL/MariaDB only - `title` and `description` indexed
- **Cultural coordinates**: `latitude` DECIMAL(10,8), `longitude` DECIMAL(11,8) for Google Maps

**Route Patterns:**
```php
// Public IP routes - accessible without auth
Route::get('/ip', [IpController::class, 'index'])->name('ip.public.index');
Route::get('/ip/{ip}', [IpController::class, 'show'])->name('ip.public.show');

// Admin routes - require 'admin' middleware  
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('cultural-items', CulturalItemController::class);
});

// IP management - require 'ip.permission' middleware (admin OR ip_manager)
Route::middleware(['auth', 'verified', 'ip.permission'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('intellectual-property', IntellectualPropertyController::class);
});

// Authenticated user profile routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
```

**Model Relationships & Scopes:**
```php
// Always eager load for display to avoid N+1
IntellectualProperty::with(['owner', 'creator'])->get();

// Use scopes for common queries (defined in models)
$ips = IntellectualProperty::active()->ofType(IpType::PATENT)->get();

// Cultural items with coordinates for maps
CulturalItem::whereNotNull('latitude')->whereNotNull('longitude')->get();

// Featured items for homepage
CulturalItem::where('is_featured', true)->orderBy('featured_order')->get();
```

## 🔀 Critical Integration Points

**AdminLTE Integration**: 
- Backend views extend `layouts.admin` for consistent admin UI
- All admin controllers in `app/Http/Controllers/Admin/` namespace
- AdminLTE components used in `resources/views/admin/` structure
- Sidebar configured in `config/adminlte.php`

**Google Maps Integration**:
- Configuration in `config/maps.php` with API key from `GOOGLE_MAPS_API_KEY` env var
- Default coordinates set to Thonburi area (13.7563°N, 100.5018°E)
- Admin forms include draggable marker picker for coordinate input
- Public views display embedded maps for cultural items with valid coordinates
- Coordinates validated: latitude DECIMAL(10,8), longitude DECIMAL(11,8)

**Tailwind CSS Theming**:
- Custom color palette in `tailwind.config.js` with Thonburi-specific colors:
  - `thonburi-gold`: Temple ornament inspired yellows/golds
  - `thonburi-navy`: Chao Phraya River depth blues
  - `thonburi-river`: Navigation-friendly river blues
- Build command: `npm run dev` (development) or `npm run build` (production)
- Vite handles asset compilation via `vite.config.js`

**File Uploads**:
- IP attachments stored in `storage/app/ip-attachments/`
- Use `ip.attachments.max_size` config for validation (see `config/filesystems.php`)
- Cultural item images in `storage/app/public/cultural-items/`
- Run `php artisan storage:link` to create public symlink

**Deployment (Railway)**:
- **Build script**: `composer railway-build` runs asset compilation + Laravel cache optimizations
- **Start script**: `composer railway-start` runs migrations + serves app
- **Database**: SQLite at `/tmp/database.sqlite` in production (configured in `railway.toml`)
- **Environment**: Set variables via Railway dashboard or `railway.toml`
- **Healthcheck**: `/up` endpoint with 300s timeout
- **Important**: Always run `npm run build` before deploying to compile Vite assets

## 🐛 Debugging & Tools

**Xdebug Configuration**:
- Use `.\reconfigure_xdebug.bat` to fix coverage issues (updates Xdebug DLL path)
- Custom `php-testing.ini` for testing environment with explicit Xdebug settings
- Coverage command: `php -d "zend_extension=C:\laragon\bin\php\...\php_xdebug.dll" -d "xdebug.mode=coverage" vendor/bin/pest`

**Common Debug Commands**:
```bash
# Debug IP routes and bindings
php .\test_route_binding.php

# Check IP data integrity  
php .\check_ip_data.php
php .\check_ip_details.php          # Detailed IP relationship checks

# Test specific IP features
php .\debug_ip_show.php

# Cultural data verification
php .\check_cultural_data.php       # Verify coordinates and relationships
php .\check_cultural_item_images.php  # Image existence validation
php .\check_community_images.php    # Community image validation
```

**Error Patterns to Watch:**
- **Route binding failures**: `ip_id` vs `id` mismatch - IP model uses custom primary key
- **Enum validation errors**: Invalid types/statuses - must match `IpType`/`IpStatus` enum values
- **Policy authorization failures**: Check `IntellectualPropertyPolicy` - owner-based access control
- **Missing view files**: Frontend views in `resources/views/frontend/`, admin in `resources/views/admin/`
- **Coordinate validation**: Latitude must be valid DECIMAL(10,8), longitude DECIMAL(11,8)
- **Fulltext search**: Only works on MySQL/MariaDB, not SQLite (production vs development difference)

## 📊 Domain-Specific Logic

**IP Registration Workflow:**
1. Draft → Pending (user submits)
2. Pending → Registered (admin approval via `IntellectualPropertyService::registerIP()`)
3. Registered → Active (auto-transition)
4. Monitor expiry via scheduled notifications

**Cultural Item Management:**
- Features system: `is_featured` + `featured_order` for homepage
- Category-based organization with slugs
- Community relationships for geographical context

**Role-Based Access**:
- `admin`: Full IP + cultural management
- `ip_manager`: IP-only operations  
- `user`: View access + own IP submissions