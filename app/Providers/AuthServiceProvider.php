<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('owned-by-user', function($user, $model) 
        {   
            return $user->owns($model);
        });

        $gate->define('has-transaction', function($user, $transaction) 
        {   
            return $user->hasTransaction($transaction);
        });

        $gate->define('has-recurring', function($user, $transaction) 
        {   
            return $user->hasRecurring($transaction);
        });

        $gate->define('has-property', function($user, $property) 
        {   
            return $user->hasProperty($property);
        });

        $gate->define('has-device', function($user, $device) 
        {   
            return $user->hasDevice($device);
        });
    }
}
