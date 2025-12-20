<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CulturalItemController;
use App\Http\Controllers\Admin\CulturalCategoryController;
use App\Http\Controllers\Admin\SlideshowController;
use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\ActivityCategoryController;
use App\Http\Controllers\Admin\IntellectualPropertyController;
use App\Http\Controllers\HomeStatsController;
use App\Http\Controllers\IpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Routes for the public-facing part of the website.
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/explore', [FrontendController::class, 'explore'])->name('cultural.explore');
Route::get('/explore-test', function() {
    $controller = new \App\Http\Controllers\FrontendController();
    $response = $controller->explore(request());
    $data = $response->getData();
    return view('frontend.explore_test', $data);
})->name('explore.test');
Route::get('/category/{slug}', [FrontendController::class, 'category'])->name('category');
Route::get('/cultural-item/{id}', [FrontendController::class, 'show'])->name('cultural-item.show');
Route::get('/community/{id}', [FrontendController::class, 'community'])->name('community');
Route::get('/search', [FrontendController::class, 'search'])->name('search');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'sendContact'])->name('contact.send');
Route::get('/map', [FrontendController::class, 'map'])->name('map');
Route::get('/news', [FrontendController::class, 'news'])->name('news');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/activities', [ActivityController::class, 'index'])->name('activities');
Route::get('/activity/{activity}', [ActivityController::class, 'show'])->name('activity.show');
Route::get('/activities/category/{category}', [ActivityController::class, 'byCategory'])->name('activities.category');
Route::get('/sitemap.xml', [FrontendController::class, 'sitemap'])->name('sitemap');
Route::get('/ip', [IpController::class,'index'])->name('ip.public.index');
Route::get('/ip/{ip}', [IpController::class,'show'])->name('ip.public.show');

// Route for public stats (JSON)
Route::get('/stats/home', [HomeStatsController::class, 'index'])
  ->name('stats.home')
  ->middleware('throttle:30,1');

// Test routes for authentication debugging
Route::get('/test-auth', function() {
    return view('test-auth');
})->name('test.auth');

Route::post('/test-login', function() {
    $credentials = request()->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role
            ]
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Invalid credentials'
    ]);
})->name('test.login');

// Quick debug route
Route::get('/debug-user', function() {
    $user = \App\Models\User::where('email', 'admin@test.com')->first();
    return [
        'user_exists' => $user ? true : false,
        'user_data' => $user ? [
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role,
            'password_hash' => substr($user->password, 0, 20) . '...'
        ] : null,
        'auth_status' => Auth::check(),
        'session_config' => config('session.driver')
    ];
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes for the administrative backend.
| These routes require the user to be authenticated.
*/

// Profile Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================================================================
// Admin Routes - Protected by role-based permissions
// ===================================================================

// Dashboard - accessible by all admin panel users (admin, editor, ip_manager, viewer)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

// Cultural Items - admin and editor only
Route::middleware(['auth', 'verified', 'admin', 'permission:manage-cultural-items'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('cultural-items/export', [CulturalItemController::class, 'export'])->name('cultural-items.export');
    Route::post('cultural-items/{culturalItem}/toggle-featured', [CulturalItemController::class, 'toggleFeatured'])->name('cultural-items.toggle-featured');
    Route::post('cultural-items/bulk-action', [CulturalItemController::class, 'bulkAction'])->name('cultural-items.bulk-action');
    Route::resource('cultural-items', CulturalItemController::class);
    
    // Cultural Categories Management
    Route::resource('cultural-categories', CulturalCategoryController::class);
});

// Slideshow Management - admin and editor only
Route::middleware(['auth', 'verified', 'admin', 'permission:manage-slideshow'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('slideshow', SlideshowController::class)->except(['show']);
    Route::post('slideshow/{id}/toggle-featured', [SlideshowController::class, 'toggleFeatured'])->name('slideshow.toggle-featured');
    Route::post('slideshow/update-order', [SlideshowController::class, 'updateOrder'])->name('slideshow.update-order');
});

// Community Management - admin and editor only
Route::middleware(['auth', 'verified', 'admin', 'permission:manage-communities'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('communities', CommunityController::class);
    Route::delete('communities/bulk-delete', [CommunityController::class, 'bulkDelete'])->name('communities.bulk-delete');
    Route::get('communities/export/csv', [CommunityController::class, 'export'])->name('communities.export');
    Route::post('communities/{community}/toggle-active', [CommunityController::class, 'toggleActive'])->name('communities.toggle-active');
    Route::post('communities/{community}/update-location', [CommunityController::class, 'updateLocation'])->name('communities.update-location');
});

// Activities Management - admin and editor only
Route::middleware(['auth', 'verified', 'admin', 'permission:manage-activities'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('activities', AdminActivityController::class);
    Route::post('activities/{activity}/toggle-status', [AdminActivityController::class, 'toggleStatus'])->name('activities.toggle-status');
    
    Route::resource('activity-categories', ActivityCategoryController::class);
    Route::post('activity-categories/{activityCategory}/toggle-status', [ActivityCategoryController::class, 'toggleStatus'])->name('activity-categories.toggle-status');
});

// User Management - admin only
Route::middleware(['auth', 'verified', 'admin', 'permission:manage-users'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::patch('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

// Intellectual Property Management - admin and ip_manager only
Route::middleware(['auth', 'verified', 'admin', 'permission:manage-ip'])->prefix('admin')->name('admin.')->group(function () {
    // Custom routes must come BEFORE resource routes to prevent route conflicts
    Route::get('ip/import', [IntellectualPropertyController::class, 'showImportForm'])->name('ip.import.form');
    Route::post('ip/import', [IntellectualPropertyController::class, 'import'])->name('ip.import');
    Route::get('ip/import/template', [IntellectualPropertyController::class, 'downloadTemplate'])->name('ip.import.template');
    Route::get('ip/export', [IntellectualPropertyController::class, 'export'])->name('ip.export');
    Route::post('ip/bulk-destroy', [IntellectualPropertyController::class, 'bulkDestroy'])->name('ip.bulk-destroy');
    
    // Resource routes (these include wildcards that can conflict with custom routes)
    Route::resource('ip', IntellectualPropertyController::class);
});

// Test route for debugging IP show
Route::get('/test-ip/{id}', function($id) {
    try {
        $ip = \App\Models\IntellectualProperty::where('ip_id', $id)->first();
        
        if (!$ip) {
            return response()->json(['error' => 'IP not found'], 404);
        }
        
        // Test all the data that view needs
        $data = [
            'title' => $ip->title,
            'type' => $ip->type,
            'status' => $ip->status,
            'type_label' => $ip->type_label,
            'status_label' => $ip->status_label,
            'is_expired' => $ip->is_expired,
            'registration_number' => $ip->registration_number,
            'registration_date' => $ip->registration_date ? $ip->registration_date->format('d/m/Y') : null,
            'expiry_date' => $ip->expiry_date ? $ip->expiry_date->format('d/m/Y') : null,
            'description' => $ip->description,
            'certificate_path' => $ip->certificate_path,
            'owner' => $ip->owner ? $ip->owner->name : null,
            'creator' => $ip->creator ? $ip->creator->name : null,
            'updater' => $ip->updater ? $ip->updater->name : null,
        ];
        
        return response()->json(['success' => true, 'data' => $data]);
        
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
});

// Test admin view route (bypass auth for testing)
Route::get('/test-admin-view/{id}', function($id) {
    try {
        $ip = \App\Models\IntellectualProperty::where('ip_id', $id)->first();
        
        if (!$ip) {
            return response()->json(['error' => 'IP not found'], 404);
        }
        
        // Test data availability first
        $testData = [
            'id' => $ip->ip_id,
            'title' => $ip->title,
            'type' => $ip->type,
            'status' => $ip->status,
            'type_label_test' => $ip->type_label,
            'status_label_test' => $ip->status_label,
            'is_expired_test' => $ip->is_expired,
            'owner_test' => $ip->owner ? $ip->owner->name : 'No owner',
        ];
        
        // If we get here, data is good, now test view
        try {
            $viewContent = view('admin.ip.show', compact('ip'))->render();
            return response()->json([
                'success' => true,
                'message' => 'View rendered successfully',
                'data' => $testData,
                'view_length' => strlen($viewContent)
            ]);
        } catch (Exception $viewError) {
            return response()->json([
                'error' => 'View error: ' . $viewError->getMessage(),
                'data' => $testData,
                'file' => $viewError->getFile(),
                'line' => $viewError->getLine()
            ], 500);
        }
        
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
});

// Test admin route with auth (simulate real admin access)  
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/test-admin-auth/{id}', function($id) {
        try {
            $ip = \App\Models\IntellectualProperty::where('ip_id', $id)->first();
            
            if (!$ip) {
                return response('IP not found', 404);
            }
            
            return view('admin.ip.show', compact('ip'));
            
        } catch (Exception $e) {
            return response('Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), 500);
        }
    });
});

/*
|--------------------------------------------------------------------------
| Health Check Routes
|--------------------------------------------------------------------------
| Simple health check routes for deployment monitoring.
| Railway-compatible with hostname verification.
*/
Route::get('/health', function () {
    $host = request()->getHost();
    $userAgent = request()->userAgent();
    
    // Check if this is a Railway request
    $isRailway = str_contains($host, 'railway.app') || 
                 str_contains($host, 'healthcheck.railway.app') ||
                 str_contains(strtolower($userAgent ?? ''), 'railway');
    
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'app' => 'thonburi-culture',
        'host' => $host,
        'railway_request' => $isRailway,
        'environment' => app()->environment()
    ]);
});

Route::get('/health/simple', function () {
    return 'OK';
});

// Railway-specific health check with detailed info
Route::get('/health/railway', function () {
    $request = request();
    
    return response()->json([
        'status' => 'ok',
        'service' => 'thonburi-culture',
        'timestamp' => now()->toISOString(),
        'host' => $request->getHost(),
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'headers' => $request->header(),
        'environment' => app()->environment(),
        'railway_compatible' => true
    ]);
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
| Routes from Laravel Breeze for authentication.
*/
require __DIR__.'/auth.php';