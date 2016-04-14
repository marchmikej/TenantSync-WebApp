<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\Card;
use TenantSync\Billing\Details;
use TenantSync\Billing\Customer;
use TenantSync\Billing\Check;
use TenantSync\Billing\UsaEpayObject;

class TransactionRequest extends UsaEpayObject {
	
	protected $requiredInputFields = [
		'account_holder',
		'command',
		'amount',
		'description',
	];

	public $inputToObjectName = [
		'account_holder' => 'AccountHolder',
		'amount' => 'Details',
		'command' => 'Command',
		'details' => 'Details',
		'description' => 'Details',
		'card' => 'CreditCardData',
		'card_number' => 'CreditCardData',
		'check' => 'CheckData',
		'account_number' => 'CheckData',
		'billing_address' => 'BillingAddress',
		'recurring_billing' => 'RecurringBilling',
 	];
}