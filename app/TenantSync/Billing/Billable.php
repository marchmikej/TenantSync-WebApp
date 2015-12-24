<?php namespace TenantSync\Billing;

require_once base_path().'/vendor/usaepay-php/usaepay.php';
use TenantSync\Models\Transaction;
use TenantSync\Models\Registration;
use TenantSync\Billing\TransactionRequestFactory;

trait Billable {

	protected $soapUrl = 'https://sandbox.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl';
	protected $data;
	protected $transaction;
	protected $transactionRequest;

	public function subscription($plan = null)
	{
		return new Gateway($this, $plan);
	}

	public function customer($id)
	{
		return new Customer($id);
	}

	public function verify($properties)
	{
		$request =  new TransactionRequest($this, $properties);
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


	public function charge($amount, $type = 'card', $data = null, $toLandlord = false)
	{
		$tran = new \SoapClient($this->soapUrl);

		if(is_null($data))
		{
			$parameters = array(
			  'Command'=> isset($data['command']) ? $data['command'] : 'Sale',
			  'Details'=> array( 
			    'Invoice' => '', 
			    'PONum' => '', 
			    'OrderID' => '', 
			    'Description' => 'Sample Credit Card Sale', 
			    'Amount'=> $amount)
			); 
			// $customer = $tran->getCustomer($this->createToken(), $this->customer_id); 
			// var_export($customer);die();
			$res = $tran->runCustomerTransaction($this->createToken(), $this->customer_id, 0, $parameters);	
			return $res->RefNum;
		}
		
		if($type == 'card')
		{
			$paymentMethod = 'CreditCardData';
			$paymentData =  [
				'CardNumber' => $data['card_number'],
				'CardExpiration' => $data['exp'],
				// 'AvsStreet' => '1234 Main Street',
				// 'AvsZip' => '99281',
				'CardCode' => $data['cvv2']
				];
		}
		elseif($type == 'check')
		{
			$paymentMethod = 'CheckData';
			$paymentData =  [
				// 'CheckNumber' => $data['check_number'],
				'Routing' => $data['routing_number'],
				'Account' => $data['account_number'],
				//'AccountType' => $data['account_type'],
				//'DriversLicense' => $data['license_number'],
				//'DriversLicenseState' => $data['license_state'],
				// 'RecordType' => 'PPD'
			];
		}
		else
		{
			return redirect()->back()->withErrors(['Choose a proper payment type.']);
		}

		if(!isset($data['name']))
		{
			if($this->profile !== null)
			{
				$data['name'] = $this->profile->first_name.' '.$this->profile->last_name;
			}
			else
			{
				return ['errors' => 'No card holder entered.'];
			}
		}

		try {

			$Request = array(
				'AccountHolder' => $data['name'],
				'Details' => array(
					'Description' => 'Subscription Payment',
					'Amount' => $amount,
					// 'Invoice' => '44539'
				),
				'Command' => $type,
				$paymentMethod => $paymentData,
				// 'AddCustomer' => 'yes',
			);
			// var_export($Request);die();

			$res = $tran->runTransaction($this->createToken($toLandlord), $Request);
			if($toLandlord)
			{
				Transaction::create(['user_id' => $this->owner->id, 'reference_number' => $res->RefNum, 'amount' => $amount]);
			}
			return $res;
		}  

		catch (\SoapFault $e)  {
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			//die("QuickSale failed :" .$e->getMessage());
			return redirect()->back()->withErrors([$e->getMessage()]);
		}
	}


	public function createCustomer($data)
	{
		$tran = new \SoapClient($this->soapUrl);

		if($data['type'] == 'ach')
		{
			$paymentMethod = [
				'MethodType' => 'ACH',
				'MethodName' => '',//$data['account_name'],
				'Routing' => $data['routing_number'],
				'Account' => $data['account_number'],
				'AccountType' => '',
				'SecondarySort' => '',
			];
		}
		else
		{
			$paymentMethod = [
					'CardNumber'=>$data['card_number'],
					'CardExpiration'=>$data['exp'],
					'CardCode'=>$data['cvv2'],
					'AvsStreet'=>'',
					'AvsZip'=>'', 					
					"MethodName"=>"",
					"SecondarySort"=> '',
			];
		}


		$CustomerData=array(
			'BillingAddress'=>array(
				'FirstName'=>$data['first_name'],
				'LastName'=>$data['last_name'],
				// 'Company'=>'Acme Corp',
				// 'Street'=>'1234 main st',
				// 'Street2'=>'Suite #123',
				// 'City'=>'Los Angeles',
				// 'State'=>'CA',
				// 'Zip'=>'12345',
				// 'Country'=>'US',
				'Email'=>$data['email'],
				'Phone'=>$data['phone']),
			'PaymentMethods' => [$paymentMethod],
			'CustomerID'=>'',
			'Description'=> 'TenantSync Subscription',
			'Enabled'=> true,
			'Amount'=>'25',
			// 'Tax'=>'0',
			'Next'=>'',
			'Notes'=>'TenantSync Customer',
			'NumLeft'=>'',
			'OrderID'=>'',
			'ReceiptNote'=>'TenantSync Registration',
			'Schedule'=>'monthly',
			'SendReceipt'=>false,
			// 'Source'=>'Recurring',
			// 'User'=>'',
			// 'CustNum'=>'C'.rand()
		);
		// var_export($CustomerData);die();
		return $customerId = $tran->addCustomer($this->createToken(), $CustomerData);
	}

	public function updateCustomerId($customerId)
	{
			$this->customer_id = $customerId;
			$this->save();
	}


	public function addDevice()
	{
		$tran = new \SoapClient($this->soapUrl);
		$token = $this->createToken();

		try { 
 
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
		  	var_export($daysLeftInCycle);die();

		  $res = $tran->updateCustomer($token, $this->customer_id, $customer); 
		} 
		 
		catch (\SoapFault $e)  {
			echo $tran->__getLastRequest();
			echo $tran->__getLastResponse();
			//die("QuickSale failed :" .$e->getMessage());
			return redirect()->back()->withErrors([$e->getMessage()]);
		}
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
		  		Transaction::create(['user_id' => $this->id, 'amount' => $transaction->Details->Amount, 'reference_number' => $transaction->Response->RefNum]);
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