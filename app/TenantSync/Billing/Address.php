<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class Address extends UsaEpayObject {
	
	public $inputToObjectName = [
		'first_name' => 'FirstName',
		'last_name' => 'LastName',
		'company' => 'Company',
		'address' => 'Street',
		'line_2' => 'Street2', 
		'address' => 'Street',
		'city' => 'City',
		'state' => 'State',
		'zip' => 'Zip',
		'phone' => 'Phone',
		'fax' => 'Fax',
		'email' => 'Email'
	];

	protected $requiredInputFields = [
		'first_name',
		'last_name',
		'address',
		'city',
		'state',
		'zip',
	];

}