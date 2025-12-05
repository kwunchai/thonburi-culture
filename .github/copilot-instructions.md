# Thonburi Culture - AI Coding Agent Instructions

This is a **bilingual Thai cultural heritage management system** built with Laravel 12, featuring **dual domains**: traditional cultural items and intellectual property (IP) management. The project uses **Thai language** extensively in UI, database fields, and comments.

## 🏗️ Architecture Overview

**Core Domains:**
- **Cultural Heritage**: `CulturalItem`, `CulturalCategory`, `Community`, `Place` models with Google Maps integration
- **Intellectual Property**: `IntellectualProperty` model with comprehensive IP lifecycle management
- **Dual Frontend**: Public cultural exploration + Admin dashboard with role-based access

**Key Architectural Patterns:**
- **Custom Route Binding**: IP models use `ip_id` as route keys (see `IntellectualProperty::getRouteKeyName()`)
- **Enum-Driven Design**: `IpType` and `IpStatus` enums with Thai labels (see `app/Enums/`)
- **Service Layer**: `IntellectualPropertyService` handles complex business logic like registration workflows
- **Policy-Based Authorization**: All IP operations controlled via `IntellectualPropertyPolicy`
- **Maps Integration**: Google Maps API for cultural item geolocation (config/maps.php)

## 🔧 Development Workflow

**Local Development (Laragon/Windows):**
```bash
# Test with coverage (primary workflow)
.\test_coverage.bat                # Runs complete IP test suite with Xdebug coverage

# Quick testing iterations  
.\test.bat                        # Fast test execution without coverage
vendor\bin\pest --filter IntellectualPropertyTest

# Database setup/reset
php artisan migrate:fresh --seed
php .\setup_cultural_data.php     # Populate cultural test data with coordinates
```

**Key Testing Patterns:**
- **Pest Framework**: Primary test runner (see `tests/Pest.php` configuration)
- **Feature Tests**: Use `tests/Feature/IntellectualPropertyTest.php` as template
- **API Testing**: All IP endpoints tested with JSON assertions and status codes
- **Factory Pattern**: Use `IntellectualProperty::factory()` for test data
- **Coverage Target**: Maintain >70% coverage on core IP functionality

**Google Maps Development:**
```bash
# Test Google Maps integration
php .\test_google_maps.php        # Verify API key and coordinate storage
# Check cultural data with coordinates
php .\check_cultural_data.php     # Debug coordinate-related issues
```

## 🧩 Key Conventions

**Database Schema:**
- IP table uses `ip_id` as primary key (not `id`)
- Enum columns: `type` (IpType), `status` (IpStatus)  
- Polymorphic ownership: `owner_id` + `owner_type`
- JSON metadata column for flexible additional data
- Cultural items have `latitude`/`longitude` for Google Maps (decimal 10,8 and 11,8)

**Route Patterns:**
```php
// Public IP routes use slug binding
Route::get('/ip/{ip:slug}', [IpController::class, 'show'])->name('ip.show');

// Admin routes use ip_id binding  
Route::prefix('admin')->group(function () {
    Route::resource('intellectual-property', IntellectualPropertyController::class);
});
```

**Model Relationships:**
```php
// Always eager load for display
IntellectualProperty::with(['owner', 'creator'])->get();

// Use scopes for common queries
$ips = IntellectualProperty::active()->ofType(IpType::PATENT)->get();

// Cultural items with coordinates
CulturalItem::whereNotNull('latitude')->whereNotNull('longitude')->get();
```

## 🔀 Critical Integration Points

**AdminLTE Integration**: 
- Views extend `layouts.admin` for backend pages
- Use AdminLTE components in `resources/views/admin/` structure

**Google Maps Integration**:
- Configuration in `config/maps.php` with API key from `GOOGLE_MAPS_API_KEY` env var
- Default coordinates set to Thonburi area (13.7563, 100.5018)
- Admin forms include draggable marker picker for coordinate input
- Public views display maps for cultural items with coordinates

**File Uploads**:
- IP attachments stored in `storage/app/ip-attachments/`
- Use `ip.attachments.max_size` config for validation

**Deployment (Railway)**:
- Build command includes asset compilation + Laravel optimizations
- Database migrations run automatically on deploy
- Environment variables managed via Railway dashboard

## 🐛 Debugging & Tools

**Xdebug Configuration**:
- Use `.\reconfigure_xdebug.bat` to fix coverage issues
- Custom `php-testing.ini` for testing environment

**Common Debug Commands**:
```bash
# Debug IP routes and bindings
php .\test_route_binding.php

# Check IP data integrity  
php .\check_ip_data.php

# Test specific IP features
php .\debug_ip_show.php
```

**Error Patterns to Watch:**
- Route binding failures on `ip_id` vs `id` mismatch
- Enum validation errors when invalid types/statuses submitted
- Policy authorization failures in IP admin actions
- Missing view files: Check `resources/views/frontend/` for complete route coverage

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