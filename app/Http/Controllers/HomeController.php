<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager as Auth;
use Illuminate\Http\Request;
use TenantSync\Models\Device;
use TenantSync\Models\Property;
use TenantSync\Models\User;
use TenantSync\Mutators\PropertyMutator;

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
		$manager = $this->user->manager();
		
		$devices = $this->user->devices->load(['property', 'alarm']);

		return view('TenantSync::manager.index', compact('devices', 'manager'));
	}

	public function manager()
	{
		$manager = $this->user->manager;

		return view('TenantSync::manager.index', compact('manager'));
	}

	public function test()
    {
        $file= public_path(). "/images/app-debug.apk";

    	$headers = array(
        	'Content-Type: application/vnd.android.package-archive',
        );
        
        $file = \File::get($file);
    	
	    $response = \Response::make($file, 200);

	    return $response;
    	// return response()->download($file, 'app-debug.apk', $headers);
    }

}  
