<?php

namespace App\Listeners;

use App\Events\AccountApprovedEvent;
use App\Events\ProfileSubmittedForApproval;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\AccountApprovedNotification;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AccountApprovedListener implements ShouldQueue
{
    public function handle(AccountApprovedEvent $event)
    {
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notify(new AccountApprovedNotification ($event->profile));
        } else {
            // Log or implement alternative notification if no admin found
            Log::info('No admin user found to notify about profile approval.');
        }
    }
}

