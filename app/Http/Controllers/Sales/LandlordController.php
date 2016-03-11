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
		$landlords = User::where(['role' => 'landlord'])->get();

		return view('TenantSync::sales.landlord.index', compact('landlords'));
	}

	public function store(Billing $billing, Mailer $mailer)
	{
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

		$landlord->addDevice($landlord->devices->first());

		return view('TenantSync::sales.landlord.show', compact('landlord', 'states'));
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

		return 'Success';

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
