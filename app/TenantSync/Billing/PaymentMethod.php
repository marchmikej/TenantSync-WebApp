<?php

namespace TenantSync\Billing;

class PaymentMethod extends UsaEpayObject {

	protected $fillable = [
		'id' => 'MethodID',
		'method_name' => 'MethodName',
		'card_number' => 'CardNumber',
		'expiration' => 'CardExpiration',
		'routing_number' => 'Routing',
		'account_number' => 'Account',
		'sort_order' => 'SecondarySort',
	];

	protected $required = [
		'method_name',
		'sort_order',
	];

	public function sortOrder()
	{
		if(! isset($this->option['sort_order'])) 
		{
			return 0;
		}
		return $this->option['sort_order'];
	}
}