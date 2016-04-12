<?php

namespace TenantSync\Billing;

class PaymentMethods extends UsaEpayObject {

	public $inputToObjectName = [
		'card_number' => 'PaymentMethod',
		'account_number' => 'PaymentMethod',
	];

	protected $requiredInputFields = [
	];

	public $emptyableRequiredFields = [
	];
}