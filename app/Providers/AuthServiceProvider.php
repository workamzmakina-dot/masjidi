<?php

namespace App\Providers;

use App\Models\MosqueUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Platform Admin Gate
        Gate::define('access-platform', function ($user) {
            return $user instanceof \App\Models\User;
        });

        // Mosque Admin / Finance Roles (Allowed to spend money/broadcast)
        Gate::define('manage-finance', function (MosqueUser $user) {
            return in_array($user->role, ['admin', 'treasurer', 'finance']);
        });

        // Mosque Content Roles (Allowed to manage subscribers/templates)
        Gate::define('manage-content', function (MosqueUser $user) {
            return in_array($user->role, ['admin', 'editor', 'imam']);
        });
    }
}