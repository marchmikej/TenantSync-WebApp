<?php namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use TenantSync\Models\Device; 
use TenantSync\Models\Transaction;
use App\Http\Controllers\Controller;
use TenantSync\Models\MaintenanceRequest;
use App\Events\LandlordRespondedToMaintenance;
use App\Http\Controllers\Traits\AuthorizesUsers;

class MaintenanceController extends Controller {

	use AuthorizesUsers;

	public function __construct(Device $device)
	{
		$this->device = $device;

		parent::__construct();
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$maintenanceRequests = MaintenanceRequest::where('user_id', '=', $this->user->id)->get();
		return view('TenantSync::landlord/maintenance/index', compact('maintenanceRequests'));
	}

	public function all()
	{
		if(!empty($this->input['device_id']))
		{
			return MaintenanceRequest::where('device_id', '=', $this->input['device_id'])->orderBy('created_at')->get()->keyBy('id');
		}
		else
		{
			// return Message::where('device_id', '=', $this->user->devices->fetch('id')->toArray())->take(10)->get()->keyBy('id');
			return MaintenanceRequest::where('user_id', '=', $this->user->id)->with('device')->take(5)->orderBy('created_at')->get()->keyBy('id');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	
		$maintenanceRequest = MaintenanceRequest::find($id);

		if(Gate::denies('owned-by-user', $maintenanceRequest))
		{
			return abort(403, "Thats not yours!");
		}
		
		return view('TenantSync::landlord/maintenance/show', compact('maintenanceRequest'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Requests\MaintenanceUpdatedRequest $request)
	{
		$maintenanceRequest = MaintenanceRequest::find($id);

		if(Gate::denies('owned-by-user', $maintenanceRequest))
		{
			return abort(403, "Thats not yours!");
		}

		$this->input['appointment_date'] = strtotime($this->input['appointment_date']);
		
		if (substr($this->input['appointment_date'], -2) == 'pm') 
		{
			$this->input['appointment_date'] = $this->input['appointment_date'] + 12*60*60;
		}
		$this->input['appointment_date'] = date('Y-m-d H:i:s', $this->input['appointment_date']);
		$maintenanceRequest = MaintenanceRequest::find($id);

		if($maintenanceRequest->appointment_date !== $this->input['appointment_date'])
		{
			$maintenanceRequest->status = 'awaiting_approval';
		}
		$maintenanceRequest->update($this->input);

		if(empty(Transaction::find($maintenanceRequest->transaction_id)))
		{
			$transaction = Transaction::create(['user_id' => $maintenanceRequest->user_id, 'description' => 'Maintenance Request '.$maintenanceRequest->id, 'payable_type' => 'device', 'payable_id' => $maintenanceRequest->device->id]);
			$maintenanceRequest->update(['transaction_id' => $transaction->id]);
		}

		if(isset($this->input['cost']))
		{
			$transaction = Transaction::find($maintenanceRequest->transaction_id);
			$transaction->update(['amount' => $this->input['cost']]);
		}

		\Event::fire(new LandlordRespondedToMaintenance($maintenanceRequest->device->id, 'Maintenance response received.'));

		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
