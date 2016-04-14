<?php namespace App\Http\Controllers\Sales;

use App\Services\Registrar;
use TenantSync\Models\User;
use App\Http\Utilities\State;
use Illuminate\Contracts\Mail\Mailer;
use App\Http\Requests\LandlordRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

class LandlordController extends SalesController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$landlords = User::where(['role' => 'landlord'])->get();

		return view('TenantSync::sales.landlord.index', compact('landlords'));
	}

	public function create()
	{
		$states = State::all();

		return view('TenantSync::sales/landlord/create2', compact('states'));
	}

	public function store(LandlordRequest $landlordRequest, PasswordBroker $passwordBroker)
	{
		\DB::beginTransaction();

		$landlord = Registrar::registerLandlord($this->input);

  		$states = State::all();
		
		if(! \App::runningUnitTests()) {
			$passwordBroker->sendResetLink(['email' => $landlord->email]);
		}

		\DB::commit();

		return redirect()->action('Sales\PropertyController@create', [$landlord->id]);
	}

	public function show($id)
	{
		$states = State::all();

		$landlord = User::find($id);

		// $landlord->addDevice($landlord->devices->first());

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

		$landlord->update($this->input);

		return 'Success';

	}

	public function getBillingAccount($id)
	{
		$landlord = User::find($id);

		return response()->json($landlord->getCustomer());
	}

	public function updateBillingAccount($id)
	{
		$landlord = User::find($id);

		$this->input['recurring_amount'] = $this->input['recurringAmount'];

		$landlord->updateCustomer($this->input);

		return 'success';
	}

}
