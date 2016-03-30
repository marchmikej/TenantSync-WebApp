<?php

namespace TenantSync\Billing;

class PaymentMethod extends UsaEpayObject {

	protected $inputToObjectName = [
		'id' => 'MethodID',
		'method_name' => 'MethodName',
		'card_number' => 'CardNumber',
		'expiration' => 'CardExpiration',
		'routing_number' => 'Routing',
		'account_number' => 'Account',
		'sort_order' => 'SecondarySort',
	];

	protected $requiredInputField = [
		'method_name',
		'sort_order',
	];
}