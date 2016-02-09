<?php

namespace TenantSync\Mutators;

use App\Services\RoiCalculator;
use TenantSync\Models\Property;
use TenantSync\Mutators\ModelMutator;

class PropertyMutator extends ModelMutator{

	public function totalExpenses($property)
	{
		$amounts = array();
		foreach($property->expenses() as $expense)
		{
			$amounts[] = $expense->amount;
		}		
		return array_sum($amounts);
	}

	public function roi($property)
	{
		if(empty($property->value) || $property->value == 0) {
			return 0;
		}

		$appreciation = (new RoiCalculator)->appreciationRoi($property);
		$equity = (new RoiCalculator)->equityRoi($property);
		$cash = (new RoiCalculator)->cashRoi($property);

		$roi = ($appreciation + $equity + $cash) / 3;
		return $roi;
	}

	public function netIncome($property, $fromDate = '-1 month')
	{
		return $property->netIncome();
	}

	public function transactions($property)
	{
		$transactions = collect(\DB::table('transactions')
			->where(function($queryContainer) use ($property) {
				$queryContainer
				->where(function($query) use ($property) {
					$query->where(['payable_type' => 'property'])
						->where(['payable_id' => $property->id]);
				})
				->orWhere(function($query) use ($property) {
					$query->where(['payable_type' => 'property'])
						->whereIn('payable_id', $property->devices->pluck('id')->toArray());
				});
			})
			->get());

		return $transactions;
	}
}