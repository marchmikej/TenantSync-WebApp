<?php namespace App\Http\Controllers\Sales;

use TenantSync\Models\User;
use Illuminate\Mail\Mailer;
use App\Http\Utilities\State;
use App\Http\Controllers\Sales\BaseController;
use App\Http\Requests\LandlordRequest;
use TenantSync\Landlord\LandlordGateway;
use TenantSync\Billing\BillingInterface as Billing;
use Wsdl2PhpGenerator\Generator;


class LandlordController extends SalesController {

	public function __construct(LandlordGateway $landlordGateway)
	{
		$this->landlordGateway = $landlordGateway;
		parent::__construct();
	}

	public function index()
	{
		$landlords = User::where(['role_id' => 3]);

		return view('TenantSync::sales.landlord.index', compact('landlords'));
	}

	public function store(Billing $billing, Mailer $mailer)
	{
		//$billing->verify($this->input);
		$landlord = $this->landlordGateway->create($this->input);
		$data = ['landlord' => $landlord];
		//send email to set password
		// $mailer->send('emails.welcome', $data, function($message) use ($landlord)
		// {
		// 	$message->to($landlord->email, $landlord->first_name.' '.$landlord->last_name)->subject('Welcome to TenantSync!');
		// });
		return view('TenantSync::sales.device.create', compact('landlord'));
	}

	public function show($id)
	{
		$states = State::all();
		$landlord = User::find($id);
		//$landlord->charge(500, ['account_holder' => 'mitchtest', 'payment_type' => 'card', 'card_number' => '4000100211112222', 'expiration' => '0919', 'cvv2' => '999', 'description' => "mitch's test charge with new billable trait", 'address' => '5042 parker rd', 'zip' => '14075']);
		//$landlord->charge(500);
		$landlord->addDevice($landlord->devices->first());

		//$landlord->updateRecurringBillingTransactions();

		return view('TenantSync::sales.landlord.show2', compact('landlord', 'states'));
	}

	public function edit($id)
	{
		$landlord = User::find($id);
		return view('TenantSync::sales.landlord.edit2', compact('landlord'));
	}

	public function update($id)
	{
		$landlord = User::find($id);
		$this->landlordGateway->update($landlord, $this->input);
		return redirect()->route('sales.landlord.show', $landlord->id);

	}

	public function customer($id)
	{
		$landlord = User::find($id);
		return response()->json($landlord->getCustomer());
	}

	public function updateCustomer($id)
	{
		$landlord = User::find($id);
		return $landlord->updateCustomer($this->input);
	}

}
