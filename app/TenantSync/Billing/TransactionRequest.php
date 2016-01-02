<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\Card;
use TenantSync\Billing\Details;
use TenantSync\Billing\Customer;
use TenantSync\Billing\Check;
use TenantSync\Billing\UsaEpayObject;

class TransactionRequest extends UsaEpayObject {
	
	protected $transactionRequest;
	protected $fillable = 
	[
		'account_holder' => 'AccountHolder',
		'command' => 'Command',
		'details' => 'Details',
		'payment_type' => 
			[
				'card' => 'CreditCardData',
				'check' => 'CheckData',
			],
		'billing_address' => 'BillingAddress',
		'recurring_billing' => 'RecurringBilling',
 	];
 	protected $required = [
 		'account_holder',
 		'command',
 		'details',
 		'payment_type',
 	];

 	public function __construct($amount, $options)
 	{
 		$this->options = $options;
		$this->options['amount'] = $amount;
 	}
 	
	public function build()
	{
		return $this->properties($this->options);
	}
	
	public function command()
	{       
        if (empty($this->options['command'])) 
        {
        	return 'Sale';
        }
        return ucfirst($this->options['command']);
	}

	public function details()
	{
		return (new Details)->properties($this->options);
	}

	public function paymentType($types)
	{     
	    if (empty($this->options['payment_type']) || empty($types[$this->options['payment_type']])) 
	    {
	        throw new \InvalidArgumentException('Please provide a proper payment type.');
	    } 
	    
	    $key = $types[$this->options['payment_type']];
	    $class = __NAMESPACE__.'\\'.ucfirst($this->options['payment_type']);
	    return ['key' => $key, 'value' => (new $class)->properties($this->options)];
	}

	public function billingAddress()
	{
		return (new BillingAddress)->properties($this->options);
	}

	public function recurringBilling()
	{
		return (new RecurringBilling)->properties($this->options);
	}


}