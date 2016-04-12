<?php  

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class CustomerData extends UsaEpayObject {

	protected $requiredInputFields = [
		'recurring',
		'schedule',
	];

	public $emptyableRequiredFields = [
		'customer_id',
		// 'recurring_amount',
		'address',
		// 'next_charge',
		'cycles_left',
		'order_id',
		'receipt_note',
		'send_receipt',
		'description',
	];

	public $inputToObjectName = [
		'customer_id' => 'CustomerID',
		'customer_number' => 'CustNum',
		'card' => 'PaymentMethods',
		'card_number' => 'PaymentMethods',
		'check' => 'PaymentMethods',
		'account_number' => 'PaymentMethods',
		'source' => 'Source',
		'recurring_amount' => 'Amount',
		'recurring' => 'Enabled',
		'schedule' => 'Schedule',
		'next_charge' => 'Next',
		'cycles_left' => 'NumLeft',
		'description' => 'Description',
		'order_id' => 'OrderID',
		'address' => 'BillingAddress',
		'receipt_note' => 'ReceiptNote',
		'send_receipt' => 'SendReceipt',
		'notes' => 'Notes',
		'tax' => 'Tax',
	];
}

