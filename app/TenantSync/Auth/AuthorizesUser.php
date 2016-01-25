<?php 

namespace TenantSync\Auth;

use TenantSync\Models\Device;
use TenantSync\Models\Profile;
use TenantSync\Models\Manager;
use TenantSync\Models\MaintenanceRequest;

trait AuthorizesUser {

	public function owns($model)
	{
		if($this->id == $model->user_id || $this->id == $model->landlord_id) {
			return true;
		}
		return false;
	}

	public function hasTransaction($transaction)
	{
		$id = $transaction->id;

		$result = array_filter($this->manager->transactions(), function($transaction) use ($id) {
			return $transaction->id == $id;
		});

		return !! $result;
	}

	public function hasProperty($property)
	{
		return !! $this->manager->properties->find($property->id);
	}

	public function hasDevice($device)
	{
		$id = $device->id;
		// var_export($this->manager->devices());die();
		$result = array_filter($this->manager->devices(), function($device) use ($id) {
			return $device->id == $id;
		});
		return !! $result;
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