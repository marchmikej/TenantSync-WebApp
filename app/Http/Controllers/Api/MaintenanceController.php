<?php 

namespace App\Http\Controllers\Api;

use Gate;
use App\Events\Event;
use App\Events\LandlordRespondedToMaintenance;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMaintenanceRequest;
use TenantSync\Models\Transaction;

class MaintenanceController extends Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// return all requests
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UpdateMaintenanceRequest $request, $id)
	{
		$maintenanceRequest = MaintenanceRequest::find($id);

		if(Gate::denies('has-device', $maintenanceRequest->device))
		{
			return abort(403, "Thats not yours!");
		}
		$fields = [
			'cost',
			'status',
			'response',
			'appointment_date',
		];

		foreach($fields as $field) {
			if(isset($this->input[$field])) {
				$maintenanceRequest->$field = $this->input[$field];
			}
		}

		$maintenanceRequest->status = 'awaiting_approval';
		
		if(! count($maintenanceRequest->transaction))
		{
			$transaction = Transaction::create(['user_id' => $maintenanceRequest->user_id, 'description' => 'Maintenance Request '.$maintenanceRequest->id, 'payable_type' => 'device', 'payable_id' => $maintenanceRequest->device->id, 'date' => date('Y-m-d', time())]);
			$maintenanceRequest->update(['transaction_id' => $transaction->id]);
		}

		if(isset($this->input['cost']))
		{
			$maintenanceRequest->transaction->update(['amount' => abs($this->input['cost']) * -1, 'date' => date('Y-m-d', strtotime($maintenanceRequest->appointment_date))]);
		}

		\Event::fire(new LandlordRespondedToMaintenance($maintenanceRequest->device->id, 'Maintenance response received.'));
		$maintenanceRequest->save();

		return 'success';
	}
}