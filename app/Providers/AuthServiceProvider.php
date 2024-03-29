<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        $permissions = __('permission');
        if ($permissions && is_array($permissions)) {
            $permissions = array_keys($permissions);
            foreach ($permissions as $permission) {
                $gate->define($permission, function ($user) use ($permission) {
                    return $user->hasPerm($permission);
                });
            }
        }
    }
}
