<?php  

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class Customer extends UsaEpayObject {

	protected $requiredInputFields = [
		'amount',
	];
	// let usaepay handle error reporting on their own fields

	protected $emptyableRequiredUsaEpayFields = [];

	public $keyMap = [
		'card' => 'PaymentMethods',
		'check' => 'PaymentMethods',
		// 'amount',
		// 'billing_address',
		// 'billing_cycles',
		// 'command',
		// 'customer_id',
		// 'descriptoin',
		// 'details',
		// 'enabled',
		// 'next',
		// 'order_id',
		// 'payment_methods',
		// 'receipt_note',
		// 'schedule',
		// 'send_receipt',
	];
}