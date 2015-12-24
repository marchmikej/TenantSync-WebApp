<?php 

namespace App\Services;

use App\Services\MortgageCalculator;

class RoiCalculator {
	
	public function __construct()
	{
		$this->mortgageCalculator = new MortgageCalculator;
	}

	public function cashOnCashRoi($purchasePrice, $rent, $expenses, $taxes, $insurance = 800, $mortgagePercent = 75)
	{
		$mortgage = $purchasePrice * ($mortgagePercent/100);
		$closingCost = $purchasePrice * 0.025;
		//$rent = $this->input['rent'];
		//$expenses = $this->input['expenses'];
		//$taxes = $this->input['taxes'];
		// $insurance = 800;

		$this->mortgageCalculator->setAmountBorrowed($mortgage);
		$this->mortgageCalculator->setInterestRate(4.125);
		$this->mortgageCalculator->setYears(30);
		$mortgagePayment = $this->mortgageCalculator->calculateRepayment();
		$cashFlow = ($rent - ($mortgagePayment + ($expenses/12) + ($taxes/12) + ($insurance/12)));
		$roi = ($cashFlow * 12) / (($purchasePrice * 0.25) + $closingCost);

		return $roi;
	}

	public function calculateRoi($income, $expenses)
	{
		if(is_array($income))
		{
			$income = array_sum($income);
		}

		if(is_array($expenses))
		{
			$expenses = array_sum($expenses);
		}


		$roi = ($income - $expenses) / $expenses;
		return $roi;
	}

	public function appreciationRoi($property)
	{
		$roi = ($property->value - $property->purchase_price) / ($property->down_payment + $property->closing_costs);
		return $roi;
	}

	public function equityRoi($property)
	{
		$roi = ($property->purchase_price - $property->down_payment) / ($property->down_payment + $property->closing_costs);
		return $roi;
	}

	public function cashRoi($property)
	{
		$roi = ($property->netIncome()) / ($property->down_payment + $property->closing_costs);
		return $roi;
	}

}