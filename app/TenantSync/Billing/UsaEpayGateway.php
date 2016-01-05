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

	public function charge($amount, $options)
	{
		if (empty($options['payment_type']))
		{
			if(! array_key_exists('method_id', $options))
			{
				$options['method_id'] = 0;
			}
			return $this->chargeBillable($amount, $options);
		}

		try 
		{
			$res = $this->gateway->runTransaction($this->billable->createToken(true), (new TransactionRequest($amount, $options))->build());
			// if($toLandlord)
			// {
			// 	Transaction::create(['user_id' => $this->owner->id, 'reference_number' => $res->RefNum, 'amount' => $amount]);
			// }
			return $res;
		} 
		catch (\SoapFault $e) 
		{
			return abort(500, $e->getMessage());
		}
	}

	public function chargeBillable($amount, $options)
	{
		debug((new CustomerTransactionRequest($amount, $options))->build());
		if (! $this->billable->hasCustomerId())
		{
			throw new \InvalidArgumentException('No payment info provided or no customer Id.');
		}
		return $this->gateway->runCustomerTransaction($this->billable->createToken(), $this->billable->customer_id, $options['method_id'], [
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