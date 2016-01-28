<?php 

namespace TenantSync\Mutators;

use TenantSync\Models\User;
use TenantSync\Models\Device;
use TenantSync\Models\Property;

class TransactionMutator {
	
	public function set($field, $data)
	{
		if(is_a($data, 'TenantSync\Models\Transaction')) {
			$data->{$field} = $this->{'set'.ucfirst($field)}($data);
			return $data; 
		}	

		if(! is_a($data, 'Illuminate\\Database\\Eloquent\\Collection')) {
			$data = $data->getCollection();
		}

		$items = $data->each(function($item) use ($field) {
			return $item->{$field} = $this->{'set'.ucfirst($field)}($item);
		});
		return $items;
	}


	public function setPayable($transaction)
	{
		$model = ucfirst($transaction->payable_type);
		return $model::where(['id' => $transaction->payable_id]);
	}

	public function setAddress($transaction)
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