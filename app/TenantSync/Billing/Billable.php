<?php namespace TenantSync\Billing;

use TenantSync\Models\Transaction;
use TenantSync\Models\Registration;
use TenantSync\Billing\UsaEpayGateway;
use TenantSync\Billing\PaymentMethod;

trait Billable {

	protected $data;
	protected $transaction;
	protected $transactionRequest;

	public function charge($amount, array $options = [])
	{
		// check somehow if $this is a device and get approtpriate key and pin
		// if no 'card' or 'check' try chargeCustomer()
		if(empty($amount)) {
			throw new Exception('The amount parameter cannot be empty.');
		}

		if(empty($options)) {
			$this->chargeCustomer($amount);
		}

		if(! Util::arrayHas($options, 'command')) {
			$options['command'] = $this->getCommand($options);
		}

		return (new UsaEpayGateway($this->key, $this->pin))->charge($amount, $options);
	}

	public function chargeCustomer($amount)
	{
		if(! $this->getCustomerId()) {
			throw new Exception('No payment source provided.');
		}

		return (new UsaEpayGateway($this->key, $this->pin))->chargeCustomer($amount, $this->getCustomerId());
	}

	public function payRent($amount, $options = []) 
	{
		if(empty($amount)) {
			throw new Exception('The amount parameter cannot be empty.');
		}

		if(empty($options)) {
			$this->chargeCustomer($amount);
		}

		if(! Util::arrayHas($options, 'command')) {
			$options['command'] = $this->getCommand($options);
		}

		return (new UsaEpayGateway($this->owner->key, $this->owner->pin))->charge($amount, $options);
	}

	// public function paymentMethods()
	// {
	// 	return (new UsaEpayGateway($this->key, $this->pin))->getPaymentMethods($token, $this->getCustomerId());
	// }

	// public function updatePaymentMethod($options)
	// {
	// 	return (new UsaEpayGateway($this->key, $this->pin))->updatePaymentMethod($token, $this->getCustomerId());
	// }

	// public function addPaymentMethod($userOptions)
	// {
	// 	return (new UsaEpayGateway($this->key, $this->pin))->addPaymentMethod($token, $this->getCustomerId());
	// }

	// public function getCustomer()
	// {
	// 	return (new UsaEpayGateway($this->key, $this->pin))->getCustomer($token, $this->getCustomerId());
	// }

	// public function updateBillingInfo($options)
	// {
	// 	// update usaepay customer stuff
	// 	return (new UsaEpayGateway($this->key, $this->pin))->updateBillingInfo($token, $this->getCustomerId());
	// }

	// public function addDevice($device)
	// {
	// 	// do logic inside user model but sub out usaepay stuff to here
	// }

	// public function removeDevice()
	// {
	// 	// do logic inside user model but sub out usaepay stuff to here
	// }

	// public function usaEpayTransactions()
	// {
	// 	// pull in any usaepay transactions that are not in the database
	// 	$history = (new UsaEpayGateway($this->key, $this->pin))->getCustomerHistory($token, $customerId);

	// 	foreach($history->Transactions as $transaction)
	// 	{
	// 		$exists = Transaction::where(['reference_number' => $transaction->Response->RefNum])->exists();

	// 		if(! $exists)
	// 		{
	// 			Transaction::create([
	// 				'user_id' => $this->id, 
	// 				'amount' => $transaction->Details->Amount, 
	// 				'reference_number' => $transaction->Response->RefNum, 
	// 				'description' => $transaction->Details->Description, 
	// 				'date' => date('Y-m-d', strtotime($transaction->DateTime)), 
	// 				'payable_type' => 'user', 
	// 				'payable_id' => $this->id
	// 			]);
	// 		}
	// 	}
	// }
	
	public function getCommand($options)
	{
		return Util::arrayHas($options, 'check') ? 'check' : 'sale';
	}

	public function hasCustomerId()
	{
		return ! empty($this->customer_id);
	}

	public function getCustomerId()
	{
		return $this->customer_id;
	}
}