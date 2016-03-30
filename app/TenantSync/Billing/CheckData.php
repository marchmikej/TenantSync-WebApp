<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class CheckData extends UsaEpayObject {

	public $requiredInputFields = [
		'account_number',
		'routing_number',
	];
	
	public $inputToObjectName = [
		'check_number' => 'CheckNumber',
		'routing_number' => 'Routing',
		'account_number' => 'Account',
		'account_type' => 'AccountType',
		'license_number' => 'DriversLicense',
		'license_state' => 'DriversLicenseState',
	];
}