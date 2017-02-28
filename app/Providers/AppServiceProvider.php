<?php

namespace App\Providers;

use TenantSync\Models\User;
use TenantSync\Models\Device;
use TenantSync\Models\Manager;
use TenantSync\Models\Property;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'user' => User::class,
            'property' => Property::class,
            'device' => Device::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
