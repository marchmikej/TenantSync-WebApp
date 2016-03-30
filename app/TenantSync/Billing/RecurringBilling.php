<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class RecurringBilling extends UsaEpayObject {

	protected $inputToObjectName = [
		'repeat' => 'Schedule',
		'next' => 'Next',
		'ends' => 'Expire',
		'cycles_left' => 'NumLeft',
		'amount' => 'Amount',
		'enable_recurring' => 'Enabled',
	];
}