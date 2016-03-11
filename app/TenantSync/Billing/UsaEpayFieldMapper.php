<?php

namespace TenantSync\Billing;

class UsaEpayFieldMapper {

	protected $inputOptionToObjectName = [
		'account_holder' => 'AccountHolder',
		'amount' => 'Details',
		'command' => 'Command',
		'details' => 'Details',
		'description' => 'Details',
		'card' => 'CreditCardData',
		'check' => 'CheckData',
		'billing_address' => 'BillingAddress',
		'recurring_billing' => 'RecurringBilling',
	];
}