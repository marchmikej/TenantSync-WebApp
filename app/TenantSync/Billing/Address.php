<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class Address extends UsaEpayObject /*implements UsaEpayRequestObject*/ {
	
	protected $fillable = [
		'address' => 'Street',
		'city' => 'City',
		'state' => 'State',
		'zip' => 'Zip',
	];
	protected $required = [
		'Street',
		'City',
		'State',
		'Zip',
	];

	public function __construct()
	{
		//
	}

	public function build($options)
	{
		$this->set($options);
		stristr($this->properties);
	}

}