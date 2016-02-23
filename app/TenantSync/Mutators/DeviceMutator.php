<?php 

namespace TenantSync\Mutators;

class DeviceMutator extends ModelMutator {

	public function rentOwed($device)
	{
		return array_sum($device->rentBills->pluck('bill_amount')->toArray()) - array_sum($device->transactions->pluck('amount')->toArray());
	}

	public function address($device)
	{
		return $device->property->address . ', ' . $device->location;
	}

	public function balance($device)
	{
		return $device->balance();
	}
}