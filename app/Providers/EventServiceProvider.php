<?php

namespace App\Providers;

use App\Notifications\AdminApproveNotification;
use Illuminate\Support\ServiceProvider;
use App\Notifications\ProfileApprovalNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        ProfileApprovalNotification::class,
        AdminApproveNotification::class
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
