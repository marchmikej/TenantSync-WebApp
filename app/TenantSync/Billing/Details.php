<?php 

namespace TenantSync\Billing;

class Details extends UsaEpayObject {

	protected $requiredInputFields = [
		'amount',
		'description',
	];

	protected $emptyableRequiredFields = [
		'Invoice',
		'PurchaseOrder',
	    'OrderID',
	];

	public $inputOptionToObjectName = [
		'amount' => 'Amount',
		'invoice' => 'Invoice',
	    'purchase_order' => 'PONum',
	    'order_id' => 'OrderID',
	    'description' => 'Description',
	];
}