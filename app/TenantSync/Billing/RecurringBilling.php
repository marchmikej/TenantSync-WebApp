<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class RecurringBilling extends UsaEpayObject /*implements UsaEpayRequestObject*/ {

	protected $fillable = [
		'repeat' => 'Schedule',
		'next' => 'Next',
		'ends' => 'Expire',
		'cycles_left' => 'NumLeft',
		'amount' => 'Amount',
		'enable_recurring' => 'Enabled',
	];
	

	public function __construct()
	{
		//
	}

}