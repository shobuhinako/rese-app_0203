<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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
        $this->registerPolicies();

        // 管理者
        Gate::define('admin', function (User $user) {
            return ($user->role_id === 1);
        });

        // 店舗代表者
        Gate::define('representative', function (User $user) {
            return ($user->role_id === 2);
        });

        // 利用者
        Gate::define('general', function (User $user) {
            return ($user->role_id === 3);
        });
    }
}
