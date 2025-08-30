<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // $this->registerPolicies();
        // Gate::define('viewAny', function ($user) {
        //     return $user->hasPermissionTo('view any');
        // });
        Gate::define('restaurantAccess', function ($user) {
            return $user->role == 'restaurant';
        });
        Gate::define('sellerAccess', function ($user) {
            return $user->role == 'seller';
        });
    }
}
