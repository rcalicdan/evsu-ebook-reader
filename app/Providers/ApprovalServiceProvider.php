<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ApprovalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('view-approvals', function (User $authUser) {
            return $authUser->isSuperAdmin() || $authUser->isAdmin();
        });

        Gate::define('approve-account', function (User $authUser, User $target) {
            if ($authUser->isSuperAdmin()) {
                return true;
            }

            if ($authUser->isAdmin() && $target->isStudent()) {
                return $authUser->course === $target->course;
            }

            return false;
        });
    }
}
