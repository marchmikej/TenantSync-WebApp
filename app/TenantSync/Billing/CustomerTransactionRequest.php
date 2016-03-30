<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\Card;

class CustomerTransactionRequest extends UsaEpayObject {
	
	protected $inputToObjectName = [
		'command' => 'Command',
		'details' => 'Detials',
	];
	
	protected $requiredInputFields = [
		'command',
		'details',
	];
}