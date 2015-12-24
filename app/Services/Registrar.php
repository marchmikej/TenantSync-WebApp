<?php namespace App\Services;

require_once base_path().'/vendor/usaepay-php/usaepay.php';
use Validator;
use TenantSync\Models\User;
use TenantSync\Models\Profile;
use TenantSync\Models\Gateway;
use TenantSync\Models\Registration;
use TenantSync\Models\PaymentMethod;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	private $registrationCost = 50;
	protected $soapUrl = 'https://sandbox.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl';

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
			'role_id' => 'required|in:2,3',
			'first_name' => 'required',
			'last_name' => 'required',
			'phone' => 'required',
			// 'token' => 'required',
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
		$user = User::create([
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'role_id' => $data['role_id'],
		]);

		$user->landlord = new Profile($data);
		$user->gateway = new Gateway($data);
		$user->paymentMethods = new PaymentMethod($data);

		// Profile::create([
		// 	'user_id' => $user->id,
		// 	'first_name' => $data['first_name'],
		// 	'last_name' => $data['last_name'],
		// 	'phone' => $data['phone'],
		// 	]);

		// if($data['role_id'] !== 3 && $data['role_id'] !== 4)
		// {
		// 	Registration::create([
		// 		'user_id' => $user->id,
		// 		'ammount_due' => $this->registrationCost
		// 	]);
		// 	// $this->redirectPath = 'sales/registration/pay?user_id='.$user->id;
		// }

		Gateway::create([
			'user_id' => $user->id,
		]);

		PaymentMethod::create([
			'user_id' => $user->id,
			'name' => ucfirst($data['type']) . 'ending in ' . isset($data['card_number']) ? substr($data['card_number'], -4) : substr($data['account_number'], -4), 
		]);

		return $user;
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
			//'CustomerID'=> '',
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
