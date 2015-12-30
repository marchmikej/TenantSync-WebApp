<?php namespace TenantSync\Billing;

use TenantSync\Models\RentBill;
use TenantSync\Models\Transaction;

class RentPaymentGateway {

	public function __construct($device)
	{
		$this->device = $device;
	}

	public function makePayment($amount, $options = array())
	{
		//credit device for the amount charged
		//process all payments for bill from the device credit
		
		$bills = $this->unpaidBills($this->device);	
		$bill = $bills->shift();
		$result = $this->attemptPayment($amount);
		if($result)
		{
			$this->addTransaction($amount);
			$this->adjustBill($amount, $bill);
		}

		return $result;
	}

	public function unpaidBills()
	{
		return RentBill::where(['user_id' => $this->device->owner->id, 'device_id' => $this->device->id, 'paid' => 0, 'vacant' => 0])->orderBy('rent_month', 'asc')->get();	
	}

	public function attemptPayment($amount)
	{
		return (new UsaEpayGateway($device))->charge($amount, $options);
	}

	public function adjustBill($amount, $bill)
	{
		if(($amount - $bill->balance_due) == 0)
		{
			$this->closeBill($bill);	
		}
		if($amount > $bill->balance_due)
		{
			$this->closeBill($bill);
			$this->applyCredit($amount - $bill->balance_due);
		}
		if($amount < $bill->balance_due)
		{
			$bill->balance_due = $bill->balance_due - $amount;
		}

		return $bill;
	}

	public function applyCredit($credit)
	{
		if($this->unpaidBills)
		{
			$this->makePayment($credit);
		}
		return $this
	}

	public function markBillAsPaid($bill)
	{
		$bill->paid = 1;
		return $bill->save();
	}
}