<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\UsaEpayObject;

class Card extends UsaEpayObject {

	protected $fillable = [
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
	protected $required = [
		'card_number',
		'expiration',
		'cvv2',
	];

}