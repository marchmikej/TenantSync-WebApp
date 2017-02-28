<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('owned-by-user', function($user, $model) 
        {   
            return $user->owns($model);
        });

        Gate::define('has-transaction', function($user, $transaction) 
        {   
            return $user->hasTransaction($transaction);
        });

        Gate::define('has-recurring', function($user, $transaction) 
        {   
            return $user->hasRecurring($transaction);
        });

        Gate::define('has-property', function($user, $property) 
        {   
            return $user->hasProperty($property);
        });

        Gate::define('has-device', function($user, $device) 
        {   
            return $user->hasDevice($device);
        });
    }
}
