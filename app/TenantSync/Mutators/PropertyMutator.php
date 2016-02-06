<?php

namespace TenantSync\Mutators;

use TenantSync\Models\Property;
use TenantSync\Mutators\ModelMutator;

class PropertyMutator extends ModelMutator{

	public function totalExpenses($device)
	{
		$amounts = array();
		foreach($device->expenses() as $expense)
		{
			$amounts[] = $expense->amount;
		}		
		return array_sum($amounts);
	}

	public function roi($device)
	{
		if(empty($device->value) || $device->value == 0) {
			$device->attributes['roi'] = 0;
			return 0;
		}

		$appreciation = (new RoiCalculator)->appreciationRoi($device);
		$equity = (new RoiCalculator)->equityRoi($device);
		$cash = (new RoiCalculator)->cashRoi($device);

		$roi = ($appreciation + $equity + $cash) / 3;
		//$roi = (new RoiCalculator)->calculateRoi([$device->$incomes, ($device->value - $device->purchase_price)/$device->down_payment], [$device->expenses]);
		$device->attributes['roi'] = $roi;
		return $roi;
	}

	public function netIncome($device, $fromDate = '-1 month')
	{
		$amounts = array();
		$transactions = collect(array_merge($device->incomes()->toArray(), $device->expenses()->toArray()));
		$transactions = $transactions->filter(function($transaction) use ($fromDate) {
				return strtotime($transaction->date) >= strtotime($fromDate);
		});
		foreach($transactions as $transaction)
		{
			$amounts[] = $transaction->amount;
		}

		return array_sum($amounts);
	}
}