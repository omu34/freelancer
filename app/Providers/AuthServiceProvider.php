<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
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
    public function boot()
    {
        // $this->defineGate('approve_accounts', function ($user) {
        //     // Check if the user has the 'admin' role
        //     return $user->hasRole('admin');
        // });

        // parent::boot();
    }
}
