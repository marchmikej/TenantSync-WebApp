<?php namespace TenantSync\Billing;

require_once base_path().'/app/Services/usaepay-php/usaepay.php';
use TenantSync\Models\Transaction;
use TenantSync\Models\Registration;
use TenantSync\Billing\UsaEpayGateway;
use TenantSync\Billing\PaymentMethod;

trait Billable2 {

	protected $soapUrl = 'https://sandbox.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl';
	protected $data;
	protected $transaction;
	protected $transactionRequest;

	public function charge($amount, array $options = [])
	{
		return (new UsaEpayGateway($this))->charge($amount, $options);
	}

	public function hasCustomerId()
	{
		return ! empty($this->customer_id);
	}

	public function getCustomerId()
	{
		return $this->customer_id;
	}

	public function createToken($toLandlord = false)
	{
		$sourcekey = '_w0QMP432PiyAlbfXYC88Ehc3k7xP48F';
		$pin = '4321';

		if($toLandlord == true)
		{
			$sourcekey = $this->owner->gateway->key;
			$pin = $this->owner->gateway->pin;
		}

		// generate random seed value
		$seed=time() . rand();

		// make hash value using sha1 function
		$clear= $sourcekey . $seed . $pin;
		$hash=sha1($clear);

		// assembly ueSecurityToken as an array
		$token=array(
			'SourceKey'=>$sourcekey,
			'PinHash'=>array(
				'Type'=>'sha1',
				'Seed'=>$seed,
				'HashValue'=>$hash
			),
			'ClientIP'=>$_SERVER['REMOTE_ADDR'],
		);
		return $token;
	}


	// public function createCustomer($data)
	// {
	// 	$tran = new \SoapClient($this->soapUrl);

	// 	if($data['type'] == 'ach')
	// 	{
	// 		$paymentMethod = [
	// 			'MethodType' => 'ACH',
	// 			// 'MethodName' => 'Checking Account',
	// 			'Routing' => $data['routing_number'],
	// 			'Account' => $data['account_number'],
	// 		];
	// 	}
	// 	else
	// 	{
	// 		$paymentMethod = [
	// 				'CardNumber'=>$data['card_number'],
	// 				'CardExpiration'=>$data['exp'],
	// 				// 'CardType'=>'', 
	// 				'CardCode'=>$data['cvv2'],
	// 				'AvsStreet'=>'',
	// 				'AvsZip'=>'', 					
	//     			// 'CardPresent'=>'',
	// 				// 'MagStripe'=>'',
	// 				// 'TermType'=>'',
	// 				// 'MagSupport'=>'',
	// 				// 'XID'=>'', 
	// 				// 'CAVV'=>'',
	// 				// 'ECI'=>'',
	// 				// 'InternalCardAuth'=>'', 
	// 				// 'Pares'=>'',
	// 				// "Expires"=>"",
	// 				"MethodName"=>"",
	// 				"SecondarySort"=> '',
	// 		];
	// 	}

	// 	try {
	// 		$CustomerData=array(
	// 			'BillingAddress'=>array(
	// 				'FirstName'=>$data['first_name'],
	// 				'LastName'=>$data['last_name'],
	// 				// 'Company'=>'Acme Corp',
	// 				// 'Street'=>'1234 main st',
	// 				// 'Street2'=>'Suite #123',
	// 				// 'City'=>'Los Angeles',
	// 				// 'State'=>'CA',
	// 				// 'Zip'=>'12345',
	// 				// 'Country'=>'US',
	// 				'Email'=>$data['email'],
	// 				'Phone'=>$data['phone']),
	// 			'PaymentMethods' => $paymentMethod,
	// 			'CustomerID'=>'',
	// 			'Description'=> 'TenantSync Subscription',
	// 			'Enabled'=> true,
	// 			'Amount'=>'',
	// 			// 'Tax'=>'0',
	// 			'Next'=>'',
	// 			'Notes'=>'TenantSync Customer',
	// 			'NumLeft'=>'',
	// 			'OrderID'=>'',
	// 			'ReceiptNote'=>'TenantSync Registration',
	// 			'Schedule'=>'monthly',
	// 			'SendReceipt'=>false,
	// 			// 'Source'=>'Recurring',
	// 			// 'User'=>'',
	// 			// 'CustNum'=>'C'.rand()
	// 		);
	// 		$customerId = $tran->addCustomer($this->createToken(), $CustomerData);
	// 		$this->updateCustomerId($customerId);
	// 	}  

	// 	catch (\SoapFault $e)  {
	// 		echo $tran->__getLastRequest();
	// 		echo $tran->__getLastResponse();
	// 		//die("QuickSale failed :" .$e->getMessage());
	// 		return redirect()->route('landlord.register')->withErrors([$e->getMessage()]); 
	// 	}
	// }

	// public function __call($method, $arguments)
	// {
	// 	$token = $this->createToken();
	// 	// set this up to dynaically call methods
	// }

	public function updateCustomerId($customerId)
	{
			$this->customer_id = $customerId;
			$this->save();
	}

	public function getPaymentMethods()
	{
		$tran = new \SoapClient($this->soapUrl);
		$token = $this->createToken();

		try { 
		  return $history = $tran->getCustomerPaymentMethods($token, $this->customer_id);
		}
	  	catch (\SoapFault $e) {
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			//die("QuickSale failed :" .$e->getMessage());
			return abort(500, $e->getMessage());
		}
	}

	public function updatePaymentMethod($options)
	{
		$tran = new \SoapClient($this->soapUrl);
		$token = $this->createToken();

		try 
		{ 
			$tran->updateCustomerPaymentMethod($token, (new PaymentMethod)->properties($options), true);
			return 1;
		}
	  	catch (\SoapFault $e) 
	  	{
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			return abort(500, $e->getMessage());
		}
	}

	public function getCustomer()
	{
		$tran = new \SoapClient($this->soapUrl);
		$token = $this->createToken();
		
		try 
		{
			return $tran->getCustomer($token, $this->customer_id); 
		}
		catch (\SoapFault $e) {
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			//die("QuickSale failed :" .$e->getMessage());
			return abort(500, $e->getMessage());
		}
	}

	public function updateCustomer($options)
	{
		$tran = new \SoapClient($this->soapUrl);
		$token = $this->createToken();
		$customer = (new Customer)->properties($options);

		try 
		{
			return $tran->updateCustomer($token, $this->customer_id, $customer); 
		}
		catch (\SoapFault $e) {
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			//die("QuickSale failed :" .$e->getMessage());
			return abort(500, $e->getMessage());
		}

	}


	public function addDevice()
	{
		$tran = new \SoapClient($this->soapUrl);
		$token = $this->createToken();

		// try { 
 
		  $customer = $tran->getCustomer($token, $this->customer_id); 
		  $customer->Amount = $customer->Amount + 10.00 ; 
		  $customer->Description = 'Added a Device'; 
		  $customer->Enabled = true;

		  $transaction = Transaction::create(['user_id' => $this->id, 'amount' => 50]);
		  Registration::create(['user_id' => $this->id, 'transaction_id' => $transaction->id]);

		  //charge the customer the cost of the device for the remainder of the current billing cycle
		  // $amount = date(time());
		  // $tran->charge();
		  $daysLeftInCycle = date('j/m/Y', strtotime($customer->Next) - time());
		  //var_export($daysLeftInCycle);die();

		  $res = $tran->updateCustomer($token, $this->customer_id, $customer); 
		// } 
		 
		// catch (\SoapFault $e)  {
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			//die("QuickSale failed :" .$e->getMessage());
			//return redirect()->back()->withErrors([$e->getMessage()]);
			var_export(date('j/m/Y', strtotime($customer->Next) - time()));die();
		// }
	}

	public function removeDevice()
	{
		$tran = new \SoapClient($this->soapUrl);
		$token = $this->createToken();

		try { 
 
		  $customer = $tran->getCustomer($token, $this->customer_id); 
		 
		  $customer->Amount = $customer->Amount - 10.00 ; 
		  $customer->Description = 'Added a Device'; 
		 
		  $res = $tran->updateCustomer($token, $this->customer_id, $customer); 
		} 
		 
		catch (\SoapFault $e) {
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			//die("QuickSale failed :" .$e->getMessage());
			return redirect()->back()->withErrors([$e->getMessage()]);
		}
	}

	public function updateRecurringBillingTransactions()
	{
		$tran = new \SoapClient($this->soapUrl);
		$token = $this->createToken();

		try { 
		  $history = $tran->getCustomerHistory($token, $this->customer_id);
		  foreach($history->Transactions as $transaction)
		  {
		  	// return $history->Transactions;
		  	$exists = Transaction::where(['reference_number' => $transaction->Response->RefNum])->exists();
		  	if( ! $exists)
		  	{
		  		Transaction::create(['user_id' => $this->id, 'amount' => $transaction->Details->Amount, 'reference_number' => $transaction->Response->RefNum, 'description' => $transaction->Details->Description, 'date' => date('Y-m-d', strtotime($transaction->DateTime)), 'payable_type' => 'user', 'payable_id' => $this->id]);
		  	}
		  	continue;
		  }
		} 
		 
		catch (\SoapFault $e)  {
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			//die("QuickSale failed :" .$e->getMessage());
			return redirect()->back()->withErrors([$e->getMessage()]);
		}
	}
}