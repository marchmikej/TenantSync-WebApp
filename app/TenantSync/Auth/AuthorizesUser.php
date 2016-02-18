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
		if($this->role == 'landlord') {
			return $this->owns($transaction);
		}

		$id = $transaction->id;

		$result = array_filter($this->manager->transactions(), function($transaction) use ($id) {
			return $transaction->id == $id;
		});

		return !! $result;
	}

	public function hasProperty($property)
	{
		if($this->role == 'landlord') {
			return $this->owns($property);
		}

		return !! $this->manager->properties->find($property->id);
	}

	public function hasDevice($device)
	{
		if($this->role == 'landlord') {
			return $this->owns($device);
		}

		$id = $device->id;
		// var_export($this->manager->devices());die();
		$result = array_filter($this->manager->devices()->toArray(), function($device) use ($id) {
			return $device->id == $id;
		});
		return !! $result;
	}

	public function hasRecurring($transaction)
	{
		if($this->role == 'landlord') {
			return $this->owns($transaction);
		}

		$id = $transaction->id;

		$result = array_filter($this->manager->recurringTransactions(), function($transaction) use ($id) {
			return $transaction->id == $id;
		});

		return !! $result;
	}

}