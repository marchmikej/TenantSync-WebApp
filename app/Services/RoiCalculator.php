<?php 

namespace App\Services;

use App\Services\MortgageCalculator;

class RoiCalculator {

	/**
	 * Initialize neccessary components
	 */
	public function __construct()
	{
		$this->mortgageCalculator = new MortgageCalculator;
	}


	/**
	 * Calculate the monthly mortgage payment 
	 * 	
	 * @param  int $purchasePrice     
	 * @param  float $downPaymentPercent
	 * @param  int $loanTerm          
	 * @param  float $interestRate      
	 * @return int                    
	 */
	public function mortgagePayment($purchasePrice, $downPaymentPercent, $loanTerm, $interestRate)
	{
		$mortgage = $purchasePrice * ($downPaymentPercent/100);

		$closingCost = $purchasePrice * 0.025;

		$this->mortgageCalculator->setAmountBorrowed($mortgage);

		$this->mortgageCalculator->setInterestRate($interestRate);

		$this->mortgageCalculator->setYears($loanTerm);

		return $this->mortgageCalculator->calculateRepayment();
	}


	/**
	 * Estimate the cash on cash roi for a property
	 * 
	 * @param  int  $purchasePrice     
	 * @param  int  $rent              
	 * @param  int  $expenses          
	 * @param  int  $taxes             
	 * @param  integer $loanTerm          
	 * @param  float   $interestRate      
	 * @param  integer $insurance         
	 * @param  integer $downPaymentPercent
	 * @param  integer $closingCost       
	 * @return float                     
	 */
	public function cashOnCashRoi($purchasePrice, $rent, $expenses, $taxes, $loanTerm = 30, $interestRate = 4.25, $insurance = 800, $downPaymentPercent = 75, $closingCost = 0)
	{
		$mortgagePayment = $this->mortgagePayment($purchasePrice, $downPaymentPercent, $loanTerm, $interestRate);
		$cashFlow = ($rent - ($mortgagePayment + ($expenses/12) + ($taxes/12) + ($insurance/12)));
		$roi = ($cashFlow * 12) / (( $purchasePrice * 0.25) + $closingCost);

		return $roi;
	}


	/**
	 * Calculate the roi
	 * 
	 * @param  array $income  
	 * @param  array $expenses
	 * @return float          
	 */
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


	/**
	 * Calculate roi based on the increase in property value
	 * 
	 * @param  Property $property
	 * @return float          
	 */
	public function appreciationRoi($property)
	{
		$roi = ($property->value - $property->purchase_price) / ($property->down_payment + $property->closing_costs);

		return $roi;
	}


	/**
	 * Calculate roi based on the principal mortgage payment
	 * 
	 * @param  Property $property
	 * @return float          
	 */
	public function equityRoi($property)
	{
		$loanAmount = $property->purchase_price - $property->down_payment;

		$principalPayment = $this->mortgageCalculator->principalPayment($loanAmount, $property->mortgage_rate, $property->mortgage_term);
		// Currently only calculating equity roi for the month ^
		
		$roi = ($principalPayment) / ($property->down_payment + $property->closing_costs);

		return $roi;
	}


	/**
	 * Calculate roi based on rent income
	 * 
	 * @param  Property $property
	 * @return float          
	 */
	public function cashRoi($property)
	{
		$roi = ($property->netIncome()) / ($property->down_payment + $property->closing_costs);

		return $roi;
	}

}