<?php 

namespace App\Services;

use App\Services\MortgageCalculator;

class RoiCalculator {
	
	public function __construct()
	{
		$this->mortgageCalculator = new MortgageCalculator;
	}

	public function mortgagePayment($purchasePrice, $downPaymentPercent, $loanTerm, $interestRate)
	{
		$mortgage = $purchasePrice * ($downPaymentPercent/100);
		$closingCost = $purchasePrice * 0.025;
		//$rent = $this->input['rent'];
		//$expenses = $this->input['expenses'];
		//$taxes = $this->input['taxes'];
		// $insurance = 800;

		$this->mortgageCalculator->setAmountBorrowed($mortgage);
		$this->mortgageCalculator->setInterestRate($interestRate);
		$this->mortgageCalculator->setYears($loanTerm);
		return $this->mortgageCalculator->calculateRepayment();
	}
	public function cashOnCashRoi($purchasePrice, $rent, $expenses, $taxes, $loanTerm = 30, $interestRate = 4.25, $insurance = 800, $downPaymentPercent = 75)
	{
		$mortgagePayment = $this->mortgagePayment($purchasePrice, $downPaymentPercent, $loanTerm, $interestRate);
		$cashFlow = ($rent - ($mortgagePayment + ($expenses/12) + ($taxes/12) + ($insurance/12)));
		$roi = ($cashFlow * 12) / (( $purchasePrice * 0.25) + $closingCost);

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
		//mortgage payment principle only for the year
		$mortgageAmount = $property->purchase_price - $property->down_payment;
		$principal = $this->mortgageCalculator->principalPayment($mortgageAmount, $property->mortgage_rate, $property->mortgage_term);
		$roi = ($principal) / ($property->down_payment + $property->closing_costs);
		return $roi;
	}

	public function cashRoi($property)
	{
		$roi = ($property->netIncome()) / ($property->down_payment + $property->closing_costs);
		return $roi;
	}

}