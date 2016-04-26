<?php 

namespace TenantSync\Mutators;

use TenantSync\Mutators\ModelMutator;

class MessageMutator extends ModelMutator {

	public function address($message)
	{
		return $message->device->address;
	}
}