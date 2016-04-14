<?php 

namespace TenantSync\Mutators;

class DeviceMutator extends ModelMutator {

	public function rentOwed($device)
	{
		return $device->rentOwed();
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