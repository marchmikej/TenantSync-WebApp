<?php 

namespace TenantSync\Auth;

use TenantSync\Models\Device;
use TenantSync\Models\Profile;
use TenantSync\Models\Manager;
use TenantSync\Models\MaintenanceRequest;

trait AuthorizesUser {

	public function owns($model)
	{
		return $this->id == $model->user_id;
	}

	public function hasTransaction($transaction)
	{
		# code...
	}

	// public function owns($model)
	// {
	// 	if($this->user->role_id == 5)
	// 	{
	// 		$manager = Manager::where('user_id', '=', $this->user->id)->first();
			
	// 		if (
	// 			Device::where([
	// 			'user_id' => $manager->landlord->id,
	// 			'id' => $id
	// 			])->exists() 
	// 		&& 
	// 			$manager->devices->contains($id))
	// 		{	
	// 			return true;
	// 		}
	// 		return false;
			
	// 	}
	// 	return Device::where([
	// 		'user_id' => $this->user->id,
	// 		'id' => $id
	// 		])->exists();
	// }

}