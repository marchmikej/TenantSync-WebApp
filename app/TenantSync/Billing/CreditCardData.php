<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class CreditCardData extends UsaEpayObject {

	protected $requiredInputFields = [
		'card_number',
		'expiration',
		'cvv2',
	];

	public $inputOptionToObjectName = [
		'card_number' => 'CardNumber',
      	'expiration' => 'CardExpiration',
      	'address' => 'AvsStreet',
      	'zip' => 'AvsZip',
      	'cvv2' => 'CardCode',
      	'method_id' => 'MethodId',
      	'method_type' => 'MethodType',
      	'method_name' => 'MethodName',
      	'sort' => 'SecondarySort',
	];
}