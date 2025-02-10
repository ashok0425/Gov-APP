<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            if (in_array($user->email, ['ashok@drebba.com', 'kartavya@drebba.com'])) {
                return true;
            }
            return null;
        });
    }
}
