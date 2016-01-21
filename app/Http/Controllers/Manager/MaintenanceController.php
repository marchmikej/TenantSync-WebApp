<?php namespace App\Http\Controllers\Manager;

use Gate;
use TenantSync\Models\Device; 
use TenantSync\Models\Manager;
use TenantSync\Models\Transaction;
use App\Http\Controllers\Controller;
use TenantSync\Models\MaintenanceRequest;
use App\Events\LandlordRespondedToMaintenance;


class MaintenanceController extends Controller {

	public function __construct()
	{
		parent::__construct();
		$this->manager = $this->user->manager;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function all()
	{
		// var_export('hello');die();
		return $this->manager->maintenanceRequests(['device', 'device.property']);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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

		if(Gate::denies('has-device', $maintenanceRequest->device))
		{
			return abort(403, "Thats not yours!");
		}
		
		return view('TenantSync::manager/maintenance/show', compact('maintenanceRequest'));
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
	public function update($id)
	{
		$maintenanceRequest = MaintenanceRequest::find($id);

		if(Gate::denies('has-device', $maintenanceRequest->device))
		{
			return abort(403, "Thats not yours!");
		}

		$this->input['appointment_date'] = strtotime($this->input['appointment_date']);
		$this->input['appointment_date'] = date('Y-m-d H:i:s', $this->input['appointment_date']);
		
		if(! empty($this->input['appointment_date']))
		{
			$maintenanceRequest->status = 'awaiting_approval';
			$maintenanceRequest->appointment_date = $this->input['appointment_date'];
			$maintenanceRequest->save();
		}
		

		if(empty(Transaction::find($maintenanceRequest->transaction_id)))
		{
			$transaction = Transaction::create(['user_id' => $maintenanceRequest->user_id, 'description' => 'Maintenance Request '.$maintenanceRequest->id, 'payable_type' => 'device', 'payable_id' => $maintenanceRequest->device->id, 'date' => date('Y-m-d', time())]);
			$maintenanceRequest->update(['transaction_id' => $transaction->id]);
		}

		if(isset($this->input['cost']))
		{
			$transaction = Transaction::find($maintenanceRequest->transaction_id);
			$transaction->update(['amount' => $this->input['cost'], 'date' => date('Y-m-d', time())]);
		}

		\Event::fire(new LandlordRespondedToMaintenance($maintenanceRequest->device->id, 'Maintenance response received.'));

		return redirect()->back();
	}

	public function closeRequest($id)
	{
		$maintenanceRequest = MaintenanceRequest::find($id);
		if(Gate::denies('has-device', $maintenanceRequest->device))
		{
			return abort(403, "Thats not yours!");
		}

		$maintenanceRequest = MaintenanceRequest::find($id);
		$maintenanceRequest->status = 'closed';
		$maintenanceRequest->save();
		return $maintenanceRequest;
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
