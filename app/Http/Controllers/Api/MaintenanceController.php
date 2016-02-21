<?php 

namespace App\Http\Controllers\Api;

use App\Events\Event;
use App\Events\LandlordRespondedToMaintenance;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMaintenanceRequest;
use Gate;
use TenantSync\Models\Device;
use TenantSync\Models\MaintenanceRequest;
use TenantSync\Models\Transaction;

class MaintenanceController extends Controller {

	public function __construct()
    {
        parent::__construct();

        $this->with = isset($this->input['with']) ? $this->input['with'] : [];
        
        $this->set = isset($this->input['set']) ? $this->input['set'] : [];
        
        $this->limit = isset($this->input['limit']) ? $this->input['limit'] : null;
    }

    public function index()
    {
        $devices = MaintenanceRequest::getRequestsForUser($this->user, ['with' => $this->with, 'limit' => $this->limit]);

        return $devices;
    }

    public function forDevice($id) 
    {
    	$device = Device::find($id);

        if(Gate::denies('has-device', $device)) {
            abort(403, 'That\'s not yours!');
        }

        return $device->maintenanceRequests()->with($this->with)->get();
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
		//var_export(! count($maintenanceRequest->transaction));die();
		if(! count($maintenanceRequest->transaction))
		{
			$transaction = Transaction::create([
				'user_id' => $maintenanceRequest->user_id, 
				'description' => 
				'Maintenance Request '.$maintenanceRequest->id, 
				'payable_type' => 'property', 
				'payable_id' => $maintenanceRequest->device->property->id, 
				'date' => date('Y-m-d', time())]);
			$maintenanceRequest->update(['transaction_id' => $transaction->id]);
		}

		if(!empty($this->input['cost']))
		{
			$maintenanceRequest->transaction->update(['amount' => abs($this->input['cost']) * -1, 'date' => date('Y-m-d', strtotime($maintenanceRequest->appointment_date))]);
		}

		\Event::fire(new LandlordRespondedToMaintenance($maintenanceRequest->device->id, 'Maintenance response received.'));
		$maintenanceRequest->save();

		return 'success';
	}

	public function show($id)
	{
		$maintenanceRequest = MaintenanceRequest::with($this->with)->find($id);

		if(Gate::denies('has-device', $maintenanceRequest->device))
		{
			return abort(403, "Thats not yours!");
		}

		return $maintenanceRequest;
	}

	public function closeMaintenance($id)
	{
		$maintenanceRequest = MaintenanceRequest::with($this->with)->find($id);

		if(Gate::denies('has-device', $maintenanceRequest->device))
		{
			return abort(403, "Thats not yours!");
		}

		$maintenanceRequest->status = 'closed';

		$maintenanceRequest->save();

		return $maintenanceRequest;
	}
}