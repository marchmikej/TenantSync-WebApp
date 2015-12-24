<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\Card;

class CustomerTransactionRequest extends UsaEpayObject {
	
	protected $fillable = [
		'command' => 'Command',
		'details' => 'Detials',
	];
	protected $required = [
		// 'key' => can be an empty string
		'command',
		'details',
	];

	public function __construct($amount, $options)
	{
		$this->options['amount'] = $amount;
		$this->options = $options;
	}

	public function build()
	{
		return $this->properties($this->options);
	}

	public function details()
	{
		return (new Details)->properties($this->options);
	}
	
	public function command()
	{       
        if (empty($this->options['command'])) 
        {
        	return 'Sale';
        }
        return ucfirst($this->options['command']);
	}
}