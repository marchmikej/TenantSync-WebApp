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
		$this->addToCredit($amount);
		//process all payments for bill from the device credit
		$this->payBills($payment);

		//$bills = $this->unpaidBills();
		//$bill = $bills->shift();
	}

	public function payBills($payment)
	{
		//loop through the open bills and apply any credit to them
		$bills = $this->unpaidBills();
		//$bill = $bills->shift();
		foreach($bills as $bill)
		{
			$this->payBill($bill, $payment);
			if(! $this->deviceHasCredit())
			{
				break;
			}
		}
	}

	public function unpaidBills()
	{
		return RentBill::where(['user_id' => $this->device->owner->id, 'device_id' => $this->device->id, 'paid' => 0, 'vacant' => 0])->orderBy('rent_month', 'asc')->get();	
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

	public function addToCredit($amount)
	{
		$this->device->credit += abs($amount);
		$this->device->save();
	}

	public function subtractFromCredit($amount)
	{
		$this->device->credit = $this->device->credit - abs($amount);
		$this->device->save();
	}
}