<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager as Auth;
use TenantSync\Models\Device;
use TenantSync\Models\User;

class HomeController extends Controller {

	public function index(Auth $auth)
	{
		if($auth->check())
		{
			switch($auth->user()->role)
			{
				case 'admin':
					return $this->admin();
				case 'sales':
					//return redirect()->route('sales.index');
					return $this->sales();
				case 'landlord':
					return $this->landlord();
				case 'manager':
					return $this->manager();
			}
		}
		return view('auth/login');
	}

	public function sales()
	{
		$landlords = User::where(['role' => 'landlord'])->get();
		$devices = Device::all();
		return view('TenantSync::sales.index', compact('landlords', 'devices'));
	}

	public function landlord()
	{
		$landlord = $this->user;
		$devices = $this->user->devices->load(['property', 'alarm']);
		return view('TenantSync::landlord.index', compact('devices', 'landlord'));
	}

	public function manager()
	{
		return redirect()->route('manager.index');
	}

        
        public function test()
        {
            return view('test');
        }
}  
