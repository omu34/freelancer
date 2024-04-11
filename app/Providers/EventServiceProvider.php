<?php

namespace App\Providers;

use App\Events\AccountApprovedEvent;
use Illuminate\Support\ServiceProvider;
use App\Listeners\AccountApprovedListener;
use App\Listeners\ProfileSubmittedForApprovalListener;
use App\Notifications\ProfileSubmittedForApprovalNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        ProfileSubmittedForApprovalNotification::class => [
            ProfileSubmittedForApprovalListener::class,
        ],
        AccountApprovedEvent::class => [
            AccountApprovedListener::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
