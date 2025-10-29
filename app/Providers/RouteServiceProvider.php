<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // กำหนด Rate Limiting สำหรับ API
        $this->configureRateLimiting();

        $this->routes(function () {
            // กำหนด Route สำหรับ API
            // ใช้ prefix 'api' และ middleware 'api'
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // กำหนด Route สำหรับ Web
            // ใช้ middleware 'web'
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Rate Limiter สำหรับ API ทั่วไป
        // 60 requests ต่อนาที สำหรับผู้ใช้ที่ล็อกอินแล้ว หรือตาม IP สำหรับ Guest
        RateLimiter::for('api', function (Request $request) {
            // อ้างอิงจากเอกสาร API: Default: 60 requests per minute per user
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
        
        // หากมี Rate Limiter พิเศษสำหรับ Endpoint อื่นๆ สามารถกำหนดเพิ่มตรงนี้ได้
    }
}
