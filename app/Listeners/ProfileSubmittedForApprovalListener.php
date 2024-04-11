<?php

namespace App\Listeners;

use App\Events\ProfileSubmittedForApproval;
use App\Events\ProfileSubmittedForApprovalEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ProfileSubmittedForApprovalNotification;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileSubmittedForApprovalListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ProfileSubmittedForApproval $event
     * @return void
     */
    public function handle(ProfileSubmittedForApprovalEvent $event)
    {
        $admin = User::where('is_admin', true)->first();

        if ($admin) {
            $admin->notify(new ProfileSubmittedForApprovalNotification($event->profile));
        } else {
            Log::info('No admin user found to notify about profile approval.');
        }
    }
}
