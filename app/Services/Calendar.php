<?php 

namespace App\Services;

use TenantSync\Models\Manager;
use TenantSync\Models\MaintenanceRequest;

class Calendar {

	public function __construct()
	{
		$this->user = \Auth::user();
	}

	public function all($user)
	{
		if($user->role == 'landlord')
		{
			return $this->allLandlordEvents($user);
		}
		elseif($user->role == 'manager')
		{
			return $this->allManagerEvents($user);
		}
		else
		{
			return 'Give me a user and then you will get your events';
		}
	}

	public function allManagerEvents($user)
	{
		$manager = Manager::where(['user_id' => $user->id])->first();
		$devices = array_map(function($device) {
				return $device->id;
			}, $manager->devices()->toArray());
		$maintenanceRequests = MaintenanceRequest::whereIn('device_id', $devices)->get();
		return $maintenanceRequests->toArray();
	}

	public function allLandlordEvents($user)
	{
		$maintenanceRequests = $user->maintenanceRequests;
		return $maintenanceRequests->toArray();
	}

}