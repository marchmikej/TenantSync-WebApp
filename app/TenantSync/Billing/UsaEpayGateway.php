<?php  

namespace TenantSync\Billing;

use TenantSync\Billing\TransactionRequest;
require_once base_path().'/app/Services/usaepay-php/usaepay.php'; /* StripeGateway */

class UsaEpayGateway {

	protected $gateway;
	protected $billable;
	protected $soapUrl = 'https://sandbox.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl';

	public function __construct($billable)	
	{
		$this->billable = $billable;
		$this->gateway = new \SoapClient($this->soapUrl);
	}

	public function charge($amount, $userOptions)
	{
		// if (empty($options['payment_type']))
		// {
		// 	if(! isset($userOptions['method_id']))
		// 	{
		// 		$options['method_id'] = 0;
		// 	}
		// 	return $this->chargeBillable($amount, $userOptions);
		// }
		
		if(! isset($userOptions['command'])) {
			$userOptions['command'] = 'sale';
		}

		if (! empty($userOptions)) {
			$userOptions['amount'] = $amount;
		}

		try 
		{
			// var_export((new TransactionRequest($userOptions))->toArray());
			// var_export('<br>');
			// var_export($this->gateway->runTransaction($this->billable->createToken(), (new TransactionRequest($userOptions))->toArray()));
			return $this->gateway->runTransaction($this->billable->createToken(), (new TransactionRequest($userOptions))->toArray());
		} 
		catch (\SoapFault $e) 
		{
			return abort(500, $e->getMessage());
			//return $e;
		}
	}

	public function chargeBillable($amount, $userOptions)
	{
		//debug((new CustomerTransactionRequest($amount, $options))->build());
		if (! $this->billable->hasCustomerId())
		{
			throw new \InvalidArgumentException('No payment info provided or no customer Id.');
		}
		return $this->gateway->runCustomerTransaction($this->billable->createToken(), $this->billable->customer_id, $userOptions['method_id'], [
				'Command'=>'Sale',
				'Details' =>  [
					'Invoice' => '', 
				    'PONum' => '', 
				    'OrderID' => '', 
				    'Description' => 'Sample Credit Card Sale', 
				    'Amount'=> $amount
				    ]
			    ]);	
	}

	public function createCustomer($options)
	{

		return $customerId = $tran->addCustomer($this->createToken(), $CustomerData);
	}

}