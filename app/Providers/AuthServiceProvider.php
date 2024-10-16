<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
    public function boot(): void
    {
        //
        $this->registerPolicies();

        //admin
        Gate::define('admin', function($user) {
            return ($user->user_auth >= 0 & $user->user_auth <= 1);
        });

        //reprasentative
        Gate::define('represetative', function($user) {
            return ($user->user_auth >= 0 && $user->user_auth <= 3);
        });

        //headcoach
        Gate::define('headcoach', function($user) {
            return ($user->user_auth >= 0 && $user->user_auth <= 5);
        });

        //coach
        Gate::define('coach', function($user) {
            return ($user->user_auth >= 0 && $user->user_auth <= 6);
        });

        //user
        Gate::define('user', function($user) {
            return ($user->user_auth >= 0 && $user->user_auth <= 9);
        });
    }
}
