<?php

namespace App\Providers;

// 1. นำเข้า Model และ Policy ของคุณ
use App\Models\IntellectualProperty;
use App\Policies\IntellectualPropertyPolicy; 

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // เพิ่มการแมปของคุณตรงนี้: 'Model::class' => 'Policy::class'
        IntellectualProperty::class => IntellectualPropertyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // 2. ไม่ต้องทำอะไรเพิ่มในฟังก์ชัน boot
    }
}