<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate for managing all users
        Gate::define('approve-profiles', function (User $user) {
            return $user->role_id == 1;
        });
        // Gate::define('approve_profiles', function ($user) {
        //     // Logic to determine if the user can approve profiles
        //     // Example: return $user->hasRole('admin');
        //     return true; // Temporary placeholder, adjust as needed
        // });

        // Gate for managing freelancers, buyers
        Gate::define('view-profiles', function (User $user) {
            return $user->role_id == 3;
        });

        // Define specific gates for each entity type
        $profiles = ['freelancer', 'buyer'];
        foreach ($profiles as $profile) {
            Gate::define("manage-$profile", function (User $user) use ($profile) {
                return Gate::allows('manage_profiles', $user);
            });
        }
    }
}
