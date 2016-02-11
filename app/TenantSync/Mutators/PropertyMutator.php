<?php

namespace TenantSync\Mutators;

use App\Services\RoiCalculator;
use TenantSync\Models\Property;
use TenantSync\Mutators\ModelMutator;

class PropertyMutator extends ModelMutator {

	/**
	 * Set the total_expenses property on model
	 *
	 * @param  Property $property 
	 * @return int
	 */
	public function totalExpenses($property)
	{
		$amounts = array();
		foreach($property->expenses() as $expense)
		{
			$amounts[] = $expense->amount;
		}		
		return array_sum($amounts);
	}


	/**
	 * Set the roi property on the model
	 * 
	 * @param  Propety $property 
	 * @return int
	 */
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


	/**
	 * Set net_income property on model
	 * 
	 * @param  Property $property 
	 * @param  string $fromDate 
	 * @return int
	 */
	public function netIncome($property, $fromDate = '-1 month')
	{
		return $property->netIncome();
	}


	/**
	 * Set transactions property on model
	 * 
	 * @param  Property $property 
	 * @return Collection
	 */
	public function transactions($property)
	{
		return $property->transactions();
	}
}