<?php namespace TenantSync\Billing;

class CreditCard{

	public $card_number;
	public $exp;
	public $address;
	public $zip;
	public $cvv2;

	public function __construct($data)
	{
		$this->card_number = $data['card_number'];
		$this->exp = $data['exp'];
		$this->address = $data['address'];
		$this->zip = $data['zip'];
		$this->cvv2 = $data['card_number'];
	}
}