<?php namespace TenantSync\Billing;

use TenantSync\Models\RentBill;
use TenantSync\Models\Transaction;

class RentPaymentGateway {

	public function __construct($device)
	{
		$this->device = $device;
	}

	public function processPayment($amount, $payment)
	{
		//credit device for the amount charged
		$this->applyToCredit($amount);
		//process all payments for bill from the device credit
		$this->payBills($payment);
	}

	public function reversePayment($difference, $transaction)
	{
		$this->applyToCredit($difference);
		$bills = $this->bills('desc');
		$this->applyCreditToBills();

		// apply difference to credit
		// get all rent bills
		// subtract credit
		// unpay bill
		// if bill balance_due is 0 go to next bill

		/*
		apply credit to device
		---grab bills
		add credit to bill balance due
		--open bill (paid = 0)
			--if less than 0
		--if greater than bill_amount
			--close bill
		go to next bill		
		*/
	}

	public function payBills($payment)
	{
		//loop through the open bills and apply any credit to them
		$bills = $this->unpaidBills();
		//$bill = $bills->shift();
		foreach($bills as $bill)
		{
			$this->payBill($bill, $payment);
			if(! $this->deviceHasCredit()) {
				break;
			}
		}
	}

	// Get all the unpaid bills
	public function unpaidBills($order = 'asc')
	{
		return $this->bills($order, 0);
		//RentBill::where(['user_id' => $this->device->owner->id, 'device_id' => $this->device->id, 'paid' => 0, 'vacant' => 0])->orderBy('rent_month', 'asc')->get();
	}

	public function bills($order, $paid = null)
	{
		$query = RentBill::where(['user_id' => $this->device->owner->id, 'device_id' => $this->device->id])->orderBy('rent_month', $order);
		if($paid !== null) {
			$query->where(['paid' => $paid]);
		}
		return $query->get();
	}

	public function payBill($bill, $payment)
	{
		if($this->device->credit >= $bill->balance_due)
		{
			$this->subtractFromCredit($bill->balance_due);
			$this->addPayment($bill->balance_due, $bill, $payment);
			$this->closeBill($bill);
		}

		if($this->device->credit < $bill->balance_due)
		{
			$this->addPayment($this->device->credit, $bill, $payment);
			$this->subtractFromCredit($this->device->credit);
		}

	}

	public function addPayment($amount, $bill, $payment)
	{
		$payment->rentBills()->attach([$bill->id => ['amount' => abs($amount)]]);
		$bill->balance_due = $bill->balance_due - abs($amount);
		$bill->save();
	}

	public function deviceHasCredit()
	{
		return $this->device->credit;
	}

	public function closeBill($bill)
	{
		$bill->paid = 1;
		$bill->save();
	}

	public function applyToCredit($amount)
	{
		$this->device->credit += $amount;
		$this->device->save();
	}

	public function subtractFromCredit($amount)
	{
		$this->device->credit = $this->device->credit - abs($amount);
		$this->device->save();
	}
}