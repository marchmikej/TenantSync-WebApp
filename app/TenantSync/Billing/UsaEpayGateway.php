<?php  

namespace TenantSync\Billing;

use TenantSync\Billing\Util;
use TenantSync\Billing\UsaEpay;
use TenantSync\Billing\CustomerData;
use TenantSync\Billing\PaymentMethod;
use TenantSync\Billing\TransactionRequest;

class UsaEpayGateway {

	// Test Card 
	// number: 4000100211112222
	// exp: 0919
	// cvc: 999
	// 
	// Test check
	// routing_number: 847484748
	// account_number: 473637467
	
	protected $soapUrl;

	protected $gateway;

	protected $pin;

	private $token;

	public function __construct($key, $pin)	
	{
		$this->soapUrl = config('usaEpay.soapUrl');

		$this->gateway = new \SoapClient($this->soapUrl);

		$this->token = $this->makeToken($key, $pin);
	}

	public function makeToken($sourceKey, $pin)
	{
		$seed = time() . rand();
		$clear = $sourceKey . $seed . $pin;
		$hash = sha1($clear);

		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '108.17.11.34';//exec('curl ifconfig.me');

		$token = [
			'SourceKey' => $sourceKey,
			'PinHash' => [
				'Type' => 'sha1',
				'Seed' => $seed,
				'HashValue' => $hash
			],
			'ClientIP' => $ip,
		];

		return $token;
	}

	public function __call($method, $parameters)
	{
		array_unshift($parameters, $this->token);

		try { 
			return call_user_func_array([$this, $method], $parameters);
		}
	  	catch (Exception $e) {
			return response()->json(['error' => $e->getMessage()]);
		}
	}

	private function charge($token, $amount, $userOptions)
	{	
		$userOptions['amount'] = $amount;

		$transactionRequest = TransactionRequest::createWith($userOptions);

		return $this->gateway->runTransaction($token, $transactionRequest); 
	}

	private function chargeCustomer($token, $customerId, $amount, $userOptions)
	{
		$methodId = $userOptions['method_id'];
		
		return $this->gateway->runCustomerTransaction($token, $customerId, $methodId, []);	
	}

	private function createAccount($token, $userOptions)
	{
		$customer = CustomerData::createWith($userOptions);

		return $this->gateway->addCustomer($token, $customer);
	}

	private function getPaymentMethods($token, $customer_id)
	{
		return $this->gateway->getCustomerPaymentMethods($token, $customer_id);
	}

	private function updatePaymentMethod($token, $userOptions)
	{
		$paymentMethod = PaymentMethod::createWith($userOptions);

		return $this->gateway->updateCustomerPaymentMethod($token, $paymentMethod, true);
	}

	private function addPaymentMethod($token, $customerId,  $userOptions)
	{
		$paymentMethod = PaymentMethod::createWith($userOptions);

		return $this->gateway->addCustomerPaymentMethod($token, $customerId, $paymentMethod, true);
	}

	private function getCustomer($token, $customerId)
	{
		return $this->gateway->getCustomer($token, $customerId);
	}

	private function updateCustomer($token, $customerId, $userOptions)
	{
		$customer = json_decode(json_encode($this->gateway->getCustomer($token, $customerId)), true);

		$customer = array_merge($customer, CustomerData::createWith($userOptions, false, false));

		return $this->gateway->updateCustomer($token, $customerId, $customer); 

	}

	// private function updateRecurringBilling()
	// {
	// 	$this->gateway = new \SoapClient($this->soapUrl);
	// 	$token = $this->createToken();
 
	// 	$customer = $this->gateway->getCustomer($token, $this->customer_id);
	// 	$customer->Amount = $this->recurringAmount(); 
	// 	$customer->Description = 'Added a Device with Id of "' . $device->id . '"'; 
	// 	$customer->Enabled = true;
	// }


	private function addDeviceToCustomer($token, $customerId, $device)
	{
 
		$customer = $this->getCustomer($token, $customerId); 

		$customer->Amount = $this->billable->recurringAmount(); 

		$customer->Description = 'Added a Device with Id of "' . $device->id . '"'; 

		$customer->Enabled = true;

		// Charge the customer the cost of the device for the remainder of the current billing cycle
		$day = date('d', strtotime($customer->Next));
		$month = date('m', strtotime($customer->Next));
		$year = date('Y', strtotime($customer->Next));

		// Calculate the number of days in this cycle
		$lengthOfThisCycle = (mktime(0,0,0, $month, $day, $year) - mktime(0,0,0, $month - 1, $day, $year)) /60/60/24;

		$daysLeftInCycle = date('d', strtotime($customer->Next) - time());

		$proRatedAmount = $device->monthly_cost * ($daysLeftInCycle / $lengthOfThisCycle);

		$this->charge($proRatedAmount);

		return $this->gateway->updateCustomer($token, $customerId, $customer); 
	}

	private function removeDevice($token, $customerId)
	{
		$customer = $this->getCustomer($token, $customerId); 
		
		$customer->Amount = $customer->Amount - 10.00 ; // Replace with the cost of the device per month

		$customer->Description = 'Removed a Device'; 
		
		return $this->gateway->updateCustomer($token, $customerId, $customer);
	}

	private function getTransactions($token, $customerId)
	{
		return $this->gateway->getCustomerHistory($token, $customerId);
	}
}