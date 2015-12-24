<?php  

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class Customer extends UsaEpayObject {

	protected $fillable = [
		'command' => 'Command',
		'details' => 'Detials',
		'payment_type' => 
		[
			'card' => 'PaymentMethods',
			'check' =>'PaymentMethods'
		],
		'billing_address' => 'BillingAddress',
		'customer_id' => 'CustomerID',
		'description' => 'Description',
		'enabled' => 'Enabled'  ,
		'amount' => 'Amount',
		// 'Tax'
		'next' => 'Next',
		'notes' => 'Notes',
		'billing_cycles' => 'NumLeft',
		'order_id' => 'OrderID',
		'receipt_note' => 'ReceiptNote',
		'schedule' => 'Schedule',
		'send_receipt' => 'SendReceipt',
	];
	protected $required = [
		// 'key' => can be an empty string
		'command',
		'details',
		'payment_type',
		'billing_address',
		'customer_id' => true,
		'description',
		'enabled',
		'amount',
		'next' => true,
		'notes',
		'billing_cycles' => true,
		'order_id' => true,
		'receipt_note',
		'schedule',
		'send_receipt',
	];

	public function __construct($amount, $options)
	{
		$this->options['amount'] = $amount;
		$this->options = $options;
	}

	public function build()
	{
		$this->properties($this->options);
	}

	public function details()
	{
		return (new Details)->properties($this->options);
	}

	public function paymentType($types)
	{     
	    if (empty($this->options['payment_type']) || empty($types[$this->options['payment_type']])) 
	    {
	        throw new InvalidArgumentException('Please provide a proper payment type.');
	    } 
	    
	    $key = $types[$this->options['payment_type']];
	    $class = __NAMESPACE__.'\\'.ucfirst($this->options['payment_type']);
	    return ['key' => $key, 'value' => (new $class)->properties($this->options)];
	}
}