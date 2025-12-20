<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define authorization gates for role-based access control
        $this->defineAuthorizationGates();
    }

    /**
     * Define authorization gates based on user roles
     */
    protected function defineAuthorizationGates(): void
    {
        // Admin has full access to everything
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        // Dashboard - all authenticated users can view
        Gate::define('view-dashboard', function ($user) {
            return true; // All logged-in users
        });

        // Cultural Items Management
        Gate::define('manage-cultural-items', function ($user) {
            return in_array($user->role, ['admin', 'editor']);
        });

        // Communities Management
        Gate::define('manage-communities', function ($user) {
            return in_array($user->role, ['admin', 'editor']);
        });

        // Activities Management
        Gate::define('manage-activities', function ($user) {
            return in_array($user->role, ['admin', 'editor']);
        });

        // Slideshow Management
        Gate::define('manage-slideshow', function ($user) {
            return in_array($user->role, ['admin', 'editor']);
        });

        // Intellectual Property Management
        Gate::define('manage-ip', function ($user) {
            return in_array($user->role, ['admin', 'ip_manager']);
        });

        // Research Management
        Gate::define('manage-research', function ($user) {
            return in_array($user->role, ['admin', 'editor']);
        });

        // Innovation Management
        Gate::define('manage-innovations', function ($user) {
            return in_array($user->role, ['admin', 'editor']);
        });

        // User Management (Admin only)
        Gate::define('manage-users', function ($user) {
            return $user->isAdmin();
        });

        // View-only permissions for Viewer role
        Gate::define('view-cultural-items', function ($user) {
            return true; // All logged-in users can view
        });

        Gate::define('view-ip', function ($user) {
            return true; // All logged-in users can view
        });
    }
}
