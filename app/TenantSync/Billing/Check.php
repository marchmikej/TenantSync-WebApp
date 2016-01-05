<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class Check extends UsaEpayObject /*implements UsaEpayRequestObject*/ {

	protected $fillable = [
		'check_number' => 'CheckNumber',
		'routing_number' => 'Routing',
		'account_number' => 'Account',
		'account_type' => 'AccountType',
		'license_number' => 'DriversLicense',
		'license_state' => 'DriversLicenseState',
	];
	protected $required = [
		'account_number',
		'routing_number',
	];
	

	public function __construct()
	{
		//
	}

	public function build($options)
	{
		$this->set($options);
	}

}