<?php namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use TenantSync\Models\Device;
use TenantSync\Models\Message;
use App\Events\DeviceMadeUpdate;
use TenantSync\Models\RentPayment;
use TenantSync\Models\Transaction;
use App\Http\Controllers\Controller;
use TenantSync\Landlord\LandlordGateway;
use TenantSync\Models\MaintenanceRequest;
use TenantSync\Billing\RentPaymentGateway;

class DeviceApiController extends Controller {

	public function __construct(Request $request)
	{
		$this->input = $request->all();

		$this->headers = $request->header();

		$this->validateDevice();

		$this->device = $this->fetchDevice();
	}

	public function getMaintenanceRequests()
	{
		$maintenanceRequests = $this->device->maintenanceRequests->filter(function($maintenanceRequest) {
			return $maintenanceRequest->isOpen();
		});

		$maintenanceRequests = $maintenanceRequests->map(function($maintenanceRequest) { // might need to array_walk this
			return [
				'id' => $maintenanceRequest->id,
				'status' => $maintenanceRequest->status,
				'request' => $maintenanceRequest->request,
				'response' => (!empty($maintenanceRequest->response)) ? $maintenanceRequest->response : null,
				'appointment' => date('M j/Y @g:ia', strtotime($maintenanceRequest->appointment_date))
			];
		});

		if($maintenanceRequests->isEmpty())
		{
			return response()->json(['There are no active requests for this device.']);
		}

		return response()->json($maintenanceRequests);
	}

	public function updateMaintenanceRequest($id)
	{	
		$maintenanceRequest = $this->device->maintenanceRequests->find($id);

		if(! $maintenanceRequest) {
			return response()->json(['error' => 'Maintenance request doesn\'t exists']);
		}

		$maintenanceRequest->update($this->input);

		\Event::fire(new DeviceUpdateMaintenance($this->device->owner->id, $this->device->id, "Maintenance Request Updated","landlord/device"));

		return response()->json(['Maintenace request updated.']);
	}

	public function storeMaintenanceRequest(MaintenanceRequest $maintenanceRequest)
	{
		// Prevent duplication from repeating requests
		if($this->device->maintenanceRequests()->where(['update_key' => $this->input['update_key']])->exists()) {
			return response()->json(['Maintenance request successfully created.']);
		}

		$maintenanceRequest = $maintenanceRequest->create([
			'user_id' => $this->device->owner->id, 
			'device_id' => $this->device->id,
			'request' => $this->input['message'], 
			'update_key' => $this->input['update_key'], 
			'status' => 'awaiting_response',
		]);
			
		\Event::fire(new DeviceUpdateMaintenance($this->device->owner->id, $this->device->id, "New Maintenance Request","landlord/device"));
		
		return response()->json(['Maintenance request successfully created.']);
	}

	public function getDevice()
	{
		$maintenanceCount = $this->device->maintenanceRequests()->where(['status' => 'awaiting_approval'])->count();

		$messageCount = $this->device->messages->count();

    	$this->device->last_contact = date('Y-m-d', time());
    	$this->device->save();

		return response()->json([
			'alarm_id' => $this->device->alarm_id,
			'status' => $this->device->status,
			'maintenanceRequests' => $maintenanceCount,
			'messages' => $messageCount
		]);
	}

	public function getMessages()
	{
		if($this->device->messages) {
			$messages = $this->device->messages()->orderBy('created_at','asc')->get(['body', 'from_device', 'created_at']);

			// This handles timezone viewing for each device
			if($this->device->timezone == null) 
			{		
				for ($y = 0; $y < count($messages); $y++)
        		{
    	        	$messages[$y]->created_at=$messages[$y]->created_at->timezone('America/New_York');
        		}
			}
			else
			{
	        	for ($y = 0; $y < count($messages); $y++)
        		{
    	        	$messages[$y]->created_at=$messages[$y]->created_at->timezone($this->device->timezone);
        		}
			}

			return $messages;
		}

		return response()->json(['No messages found.']);
	}

	public function storeMessage()
	{
		// Prevent duplication from repeating requests
		if($this->device->messages()->where(['update_key' => $this->input['update_key']])->exists()) {
			return response()->json(['Message successfully sent.']);
		}

		Message::create([
			'user_id' => $this->device->owner->id, 
			'device_id' => $this->device->id, 
			'body' => $this->input['message'], 
			'update_key' => $this->input['update_key'], 
			'from_device' => 1
		]);

		\Event::fire(new DeviceMadeUpdate($this->device->owner->id, $this->device->id, $this->input['message'],"landlord/device"));

		return response()->json(['Message created succesfully.']);
	}

	public function updateRoutingId()
	{
		$this->device->routing_id = $this->input['routing_id'];

		$this->device->save();

		return response()->json($this->device->routing_id);
	}

	public function rentStatus()
	{
		return response()->json([
			'rent_amount' => $this->device->rent_amount, 
			'balance_due' => $this->device->balance()
		]);
	}

	public function payRent()
	{ 
		// Transactions api url https://www.usaepay.com/gate.php

		\DB::beginTransaction();

		$amount = $this->input['amount'];

		$description = isset($this->input['description']) ? $this->input['description'] : 'Rent Payment';

		$transaction = [
			'amount' => $amount, 
			'user_id' => $this->device->owner->id, 
			'payable_type' => 'device', 
			'payable_id' => $this->device->id, 
			'description' => $description, 
			'date' => Carbon::now()->toDateTimeString(), 
		];

		$payment = Transaction::create($transaction);

		$response = $this->device->payRent($amount, array_merge($this->input, ['description' => $description]));

		if($response->Result == "Approved") {
			$payment->reference_number = $response->RefNum;
			
			$payment->save();

			\DB::commit();
		}
		else {
			\DB::rollback();
		}

		return response()->json(['RefNum' => $response->RefNum, 'Error' => $response->Error, 'Result' => $response->Result]);
	}

	public function validateDevice()
	{
		if(\App::runningUnitTests()) {
			return true;
		}

		if(!isset($this->headers['serial']) || !isset($this->headers['token'])) {
			return response()->json(['error' => 'Please provide the required credentials.']);
		}

		$exists = Device::where('serial', '=', $this->headers['serial'])
						->where('token', '=', $this->headers['token'])
						->exists();

		if(! $exists) {
			return response()->json(['error' => 'The device is not valid.']);
		}
	}

	public function fetchDevice()
	{
		if(\App::runningUnitTests()) {
			return Device::where(['serial' => $this->input['serial'], 'token' => $this->input['token']])->first();
		}
			
		$device = Device::where('serial', '=', $this->headers['serial'])
						->where('token', '=', $this->headers['token'])
						->first();

		if(! $device) {
			return response()->json(['Device not found.']);
		}

		return $device;
	}

	public function verifyUpgrade()
	{
		$version=$this->input['version'];
		if($version == "1.0") {
			return "tenantSync_1_1.apk";
		} if($version == "1.2") {
			return "tenantSync_1_2_1.apk";
		} else {
			return "NOUPDATE";
		}
	}
}  