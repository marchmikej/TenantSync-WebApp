<?php 

namespace TenantSync\Billing;

class Details extends UsaEpayObject {

	protected $fillable = [
		'amount' => 'Amount',
		'invoice' => 'Invoice',
	    'purchase_order' => 'PONum',
	    'orderId' => 'OrderID',
	    'description' => 'Description',
	];
	protected $required = [
		'amount' => false,
		'description' => false,
		'invoice' => true, 
	    'purchase_order' => true, 
	    'orderId' => true, 
	];
}