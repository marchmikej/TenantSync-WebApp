<?php namespace App\Services;

require_once base_path().'/vendor/usaepay-php/usaepay.php';
use Validator;
use TenantSync\Models\Registration;
use TenantSync\Models\PaymentMethod;
use TenantSync\Models\Transaction;
use TenantSync\Landlord\LandlordGateway;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class LandlordRegistrar implements RegistrarContract {

	
	protected $soapUrl = 'https://sandbox.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl';


	public function __construct()
	{
		$this->landlordGateway = new LandlordGateway;
	}


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'role_id' => 'required|in:2',
			'first_name' => 'required',
			'last_name' => 'required',
			'phone' => 'required',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		try
		{
			$customerId = $this->createCustomer($data);
		}
		catch(\Exception $e)
		{
			return redirect()->back()->withErrors([$e->getMessage()])->withInput();
		}
		$landlord = User::create($request->all());
		$landlord->updateCustomerId($customerId);
		//$landlord->charge(5000);

		$user = $this->landlordGateway->create($data);
		return $user;
	}


	/**
	 * Creates a customer in the UsaEpay master merchant account
	 *
	 * @return int customerId
	 * @author Mitchell Jamieson
	 **/

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
				'SecondarySort' => '',
			];
		}
		else
		{
			$paymentMethod = [
					'CardNumber'=>$data['card_number'],
					'CardExpiration'=>$data['exp'],
					// 'CardType'=>'', 
					'CardCode'=>$data['cvv2'],
					'AvsStreet'=>'',
					'AvsZip'=>'', 					
	    			// 'CardPresent'=>'',
					// 'MagStripe'=>'',
					// 'TermType'=>'',
					// 'MagSupport'=>'',
					// 'XID'=>'', 
					// 'CAVV'=>'',
					// 'ECI'=>'',
					// 'InternalCardAuth'=>'', 
					// 'Pares'=>'',
					// "Expires"=>"",
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
			//'CustomerID'=>'',
			'Description'=> 'TenantSync Subscription',
			'Enabled'=> true,
			'Amount'=>'25',
			// 'Tax'=>'0',
			'Next'=> date('Y-m-j', strtotime('tomorrow')),
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
		return $customerId = $tran->addCustomer($this->createToken(), $CustomerData);
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

}
