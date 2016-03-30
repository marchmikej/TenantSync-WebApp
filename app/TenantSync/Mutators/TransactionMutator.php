<?php 

namespace TenantSync\Mutators;

use TenantSync\Models\User;
use TenantSync\Models\Device;
use TenantSync\Models\Property;

class TransactionMutator extends ModelMutator {

	public function payable($transaction)
	{
		$model = ucfirst($transaction->payable_type);
		
		return $model::where(['id' => $transaction->payable_id]);
	}

	public function address($transaction)
	{
		switch($transaction->payable_type) {
			case 'TenantSync\\Models\\Device': 
				$device = Device::find($transaction->payable_id);
				return $device->property->address . ', ' . $device->location;
			case 'TenantSync\\Models\\Property':
				return Property::find($transaction->payable_id)->address;
			default:
				return 'General';
		}
	}
}