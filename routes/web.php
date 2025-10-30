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
    
    // Cultural Items Management (using resource)
    Route::get('cultural-items/export', [CulturalItemController::class, 'export'])->name('cultural-items.export');
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
    Route::get('ip/export', [IntellectualPropertyController::class, 'export'])->name('ip.export');
    Route::resource('ip', IntellectualPropertyController::class);
    
    // Additional IP routes (if any)
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
| Routes from Laravel Breeze for authentication.
*/
require __DIR__.'/auth.php';