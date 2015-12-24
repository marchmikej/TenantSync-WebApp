<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {

	//Register alias for views
	
	public function boot()
	{
			$this->loadViewsFrom(base_path().'/resources/views/tenantSync', 'TenantSync');
	}

	
	public function register()
	{
		//
	}

}