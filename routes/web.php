<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CulturalItemController;
use App\Http\Controllers\Admin\SlideshowController;
use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\HomeStatsController;
use App\Http\Controllers\IpController;
use App\Http\Controllers\Admin\IntellectualPropertyController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Routes for the public-facing part of the website.
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/explore', [FrontendController::class, 'explore'])->name('cultural.explore');
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
Route::get('/sitemap.xml', [FrontendController::class, 'sitemap'])->name('sitemap');
Route::get('/ip', [IpController::class,'index'])->name('ip.index');
Route::get('/ip/{ip:slug}', [IpController::class,'show'])->name('ip.show');

// Route for public stats (JSON)
Route::get('/stats/home', [HomeStatsController::class, 'index'])
  ->name('stats.home')
  ->middleware('throttle:30,1');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes for the administrative backend.
| These routes require the user to be authenticated.
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Routes
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
        // Cultural Items Routes
    Route::get('cultural-items/export', [CulturalItemController::class, 'export'])->name('cultural-items.export');
    Route::post('cultural-items/{culturalItem}/toggle-featured', [CulturalItemController::class, 'toggleFeatured'])->name('cultural-items.toggle-featured');
    Route::post('cultural-items/bulk-action', [CulturalItemController::class, 'bulkAction'])->name('cultural-items.bulk-action');
    Route::resource('cultural-items', CulturalItemController::class);   
    
    // Slideshow Management (using resource)
    Route::resource('slideshow', SlideshowController::class)->except(['show']); // No show method needed for slideshows
    Route::post('slideshow/{id}/toggle-featured', [SlideshowController::class, 'toggleFeatured'])->name('slideshow.toggle-featured');
    Route::post('slideshow/update-order', [SlideshowController::class, 'updateOrder'])->name('slideshow.update-order');

    // Community Management (using resource)
    Route::resource('communities', CommunityController::class);
    // Additional community routes
    Route::delete('communities/bulk-delete', [CommunityController::class, 'bulkDelete'])->name('communities.bulk-delete');
    Route::get('communities/export/csv', [CommunityController::class, 'export'])->name('communities.export');
    Route::post('communities/{community}/toggle-active', [CommunityController::class, 'toggleActive'])->name('communities.toggle-active');
    Route::post('communities/{community}/update-location', [CommunityController::class, 'updateLocation'])->name('communities.update-location');

    // Intellectual Property Management (using resource)
    Route::middleware('ip.permission')->group(function () {
        Route::get('ip/export', [IntellectualPropertyController::class, 'export'])->name('ip.export');
        Route::resource('ip', IntellectualPropertyController::class);
    });
    
    // User Management (using resource)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::patch('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Additional IP routes (if any)
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
| Auth Routes
|--------------------------------------------------------------------------
| Routes from Laravel Breeze for authentication.
*/
require __DIR__.'/auth.php';