<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notifications\ProfileApprovalNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        ProfileApprovalNotification::class
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
