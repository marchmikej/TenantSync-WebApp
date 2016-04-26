<?php 

namespace TenantSync\Mutators;

use TenantSync\Mutators\ModelMutator;

class MaintenanceRequestMutator extends ModelMutator {

	public function address($maitnenanceRequest)
	{
		return $maitnenanceRequest->device->address;
	}
}