<?php 

namespace TenantSync\Billing;

class Details extends UsaEpayObject {

	protected $requiredInputFields = [
		'amount',
		'description',
	];

	public $emptyableRequiredFields = [
		'invoice',
		'purchase_order',
	    'order_id',
	];

	public $inputToObjectName = [
		'amount' => 'Amount',
		'invoice' => 'Invoice',
	    'purchase_order' => 'PONum',
	    'order_id' => 'OrderID',
	    'description' => 'Description',
	];
}