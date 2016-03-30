<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class Address extends UsaEpayObject {
	
	protected $inputOptionToObjectName = [
		'address' => 'Street',
		'city' => 'City',
		'state' => 'State',
		'zip' => 'Zip',
	];
	protected $requiredInputFields = [
		'address',
		'city',
		'state',
		'zip',
	];

}