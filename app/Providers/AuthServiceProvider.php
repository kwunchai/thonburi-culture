<?php

namespace App\Providers;

// 1. นำเข้า Model และ Policy ของคุณ
use App\Models\IntellectualProperty;
use App\Policies\IntellectualPropertyPolicy;
use App\Models\Activity;
use App\Policies\ActivityPolicy; 
use Illuminate\Support\Facades\Gate;

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
        Activity::class => ActivityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // 2. Define custom gates
        Gate::define('manage-activities', function ($user) {
            return $user->hasRole(['admin', 'editor']);
        });
    }
}