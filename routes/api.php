<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IntellectualPropertyController;
use App\Models\IntellectualProperty;

/*
|--------------------------------------------------------------------------
| Route Model Binding
|--------------------------------------------------------------------------
*/

// Route model binding for intellectual property
Route::bind('ip', function ($value) {
    return IntellectualProperty::where('ip_id', $value)->firstOrFail();
});

/*
|--------------------------------------------------------------------------
| Intellectual Property API Routes (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {
    
    // Intellectual Property Management Group
    Route::prefix('ip')->name('ip.')->group(function () {
        
        // Standard CRUD operations
        Route::get('/', [IntellectualPropertyController::class, 'index'])
            ->name('index');
        
        Route::post('/', [IntellectualPropertyController::class, 'store'])
            ->name('store');
        
        Route::get('/{ip}', [IntellectualPropertyController::class, 'show'])
            ->name('show');
        
        Route::put('/{ip}', [IntellectualPropertyController::class, 'update'])
            ->name('update');
        
        Route::delete('/{ip}', [IntellectualPropertyController::class, 'destroy'])
            ->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Public API Routes (No Authentication Required)  
|--------------------------------------------------------------------------
*/

Route::prefix('public')->group(function () {
    
    // Get IP types and statuses
    Route::get('ip/types', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'copyright', 'patent', 'trademark', 'trade_secret', 'local_wisdom'
            ],
        ]);
    })->name('ip.types');
    
    Route::get('ip/statuses', function () {
        return response()->json([
            'success' => true,
            'data' => [
                'draft', 'pending', 'registered', 'active', 'expired', 'revoked'
            ],
        ]);
    })->name('ip.statuses');
});
