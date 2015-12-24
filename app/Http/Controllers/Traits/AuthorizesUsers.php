<?php 

namespace App\Http\Controllers\Traits;

use TenantSync\Models\Device;
use TenantSync\Models\Profile;
use TenantSync\Models\Manager;
use TenantSync\Models\MaintenanceRequest;

trait AuthorizesUsers {

	public function userOwnsDevice($id)
	{
		if($this->user->role_id == 5)
		{
			$manager = Manager::where('user_id', '=', $this->user->id)->first();
			
			if (
				Device::where([
				'user_id' => $manager->landlord->id,
				'id' => $id
				])->exists() 
			&& 
				$manager->devices->contains($id))
			{	
				return true;
			}
			return false;
			
		}
		return Device::where([
			'user_id' => $this->user->id,
			'id' => $id
			])->exists();
	}

	public function userOwnsMaintenanceRequest($id)
	{
		if($this->user->role_id == 5)
		{
			$manager = Manager::where('user_id', '=', $this->user->id)->first();
			
			if (
				MaintenanceRequest::where([
				'user_id' => $manager->landlord->id,
				'id' => $id
				])->exists() 
			&& 
				$manager->devices->contains(MaintenanceRequest::where([
				'user_id' => $manager->landlord->id,
				'id' => $id
				])->first()->device_id))
			{	
				return true;
			}
			return false;
			
		}
		return MaintenanceRequest::where([
			'user_id' => $this->user->id,
			'id' => $id
			])->exists();
	}

}