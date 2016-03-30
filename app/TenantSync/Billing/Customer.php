<?php  

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class Customer extends UsaEpayObject {

	protected $requiredInputFields = [
		'amount',
	];

	protected $emptyableRequiredUsaEpayFields = [];

	public $inputToObjectName = [
		'card' => 'PaymentMethods',
		'check' => 'PaymentMethods',
		'amount' => 'Amount',
		'billing_address' => 'BillingAddress',
		'billing_cycles' => 'BillingCycles',
		'command' => 'Command',
		'customer_id' => 'CustomerID',
		'description' => 'Discription',
		'details' => 'Details',
		'enabled' => 'Enabled',
		'next' => 'Next',
		'order_id' => 'OrderID',
		'payment_methods' => 'PaymentMethods',
		'receipt_note' => 'ReceiptNote',
		'schedule' => 'Schedule',
		'send_receipt' => 'SendReceipt',
	];
}