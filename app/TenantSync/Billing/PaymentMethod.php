<?php 

namespace TenantSync\Billing;

class PaymentMethod extends UsaEpayObject {

	public $inputToObjectName = [
		'id' => 'MethodID',
		'method_name' => 'MethodName',
		'type' => 'MethodType',
		'card_number' => 'CardNumber',
		'expiration' => 'CardExpiration',
		'cvv2' => 'CardCode',
		'routing_number' => 'Routing',
		'account_number' => 'Account',
		'sort_order' => 'SecondarySort',
	];

	protected $requiredInputFields = [
		// 'method_type',
	];

	public $emptyableRequiredFields = [
		'sort_order',
		'method_name',
	];
}