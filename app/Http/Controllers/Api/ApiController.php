<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use TenantSync\Models\Device;
use TenantSync\Models\Message;
use TenantSync\Models\RentPayment;
use TenantSync\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Events\DeviceMadeUpdate;
use TenantSync\Landlord\LandlordGateway;
use TenantSync\Models\MaintenanceRequest;

class ApiController extends Controller {

	public function __construct(Request $request)
	{
		$this->input = $request->all();
		$this->header = $request->header();
		$this->device = ($this->header['serial']) ? Device::where('serial', '=', $this->header['serial'])->first() : '';
	}
	public function allRequests()
	{
		$status = 'closed';

		if($this->deviceIsValid($this->device))
		{
			foreach($this->device->maintenanceRequests as $maintenanceRequest)
			{
				if($maintenanceRequest->status !==  $status)
				{
					$maintenanceRequests[$maintenanceRequest->id] = [
						'id' => $maintenanceRequest->id,
						'status' => $maintenanceRequest->status,
						'request' => $maintenanceRequest->request,
						'response' => (!empty($maintenanceRequest->response)) ? $maintenanceRequest->response : null,
						'appointment' => date('M j/Y @g:ia', strtotime($maintenanceRequest->appointment_date))
					];
				}
				continue;
			}
			if(!empty($maintenanceRequests))
			{
				return response()->json($maintenanceRequests);
			}
			return response()->json(['There are no active requests for this device.']);
		} 
		else 
		{
			return response()->json(['errors' => ['You are not authorized to view this resource.']]);
		}
	}

	public function storeRequest(MaintenanceRequest $maintenanceRequest, $id = null)
	{
		if($this->deviceIsValid($this->device))
		{
			if($id == null || !is_numeric($id))
			{
				$maintenanceRequest = $maintenanceRequest->create(['user_id' => $this->device->owner->id, 'request' => $this->input['message'], 'device_id' => $this->device->id, 'status' => 'open']);
				if(!empty($maintenanceRequest))
				{
					$transaction = Transaction::create(['user_id' => $this->device->owner->id]);
					$maintenanceRequest->transaction_id = $transaction->id;
					$maintenanceRequest->save();
					\Event::fire(new DeviceMadeUpdate($this->device->owner->id, $this->device->id, "New Maintenance Request","landlord/device"));
					return 'Maintenance request successfully created.';
				}
				else
				{
					return 'Failed';
				}
			}
			else
			{
				if($maintenanceRequest->find($id)->update(['status' => $this->input['status']]))
				{
					return 'Status changes to '.$this->input['status'];
				}
				else
				{
					return 'Failed';
				}
			}
		}
	}

	public function deviceIsValid($device)
	{
		if($device && $this->header['token'][0] == $device->token)
		{
			return true;	
		} 
		else 
		{
			return false;
		}
	}

	public function showDevice()
	{
		

		if($this->deviceIsValid($this->device))
		{
			foreach($this->device->maintenanceRequests as $maintenanceRequest)
			{
				if($maintenanceRequest->status ==  'open')
				{
					$maintenanceRequests[$maintenanceRequest->id] = [
						'status' => $maintenanceRequest->status,
						'request' => $maintenanceRequest->request,
						'response' => (!empty($maintenanceRequest->response)) ? $maintenanceRequest->response : null

					];
				}
				continue;
			}

			foreach($this->device->messages as $message)
			{
					$messages[$message->id] = [
						'message' => $message->body,
						'is_from_device' => $message->is_from_device,
						'created_at' => $message->created_at
						];
			}
			$maintenanceCount = \DB::table('maintenance_requests')
        		->where('status', '=', "open")
        		->where('appointment_date', '<>', "NULL")
        		->count();

			return response()->json([
				'alarm_id' => $this->device->alarm_id,
				'status' => $this->device->status,
				'maintenanceRequests' => $maintenanceCount,
				'messages' => $this->device->messages->count()
			]);
		}
	}

	public function getMessages()
	{
		if($this->deviceIsValid($this->device))
		{
			$messages = Message::where(['device_id' => $this->device->id])->orderBy('created_at','asc')->get(['body', 'is_from_device', 'created_at']);
			return response()->json($messages);
		}
		else
		{
			return response()->json(['error' => 'Device is not valid.']);
		}
		
	}

	public function createMessage()
	{
		if($this->deviceIsValid($this->device))
		{
			if(Message::create(['user_id' => $this->device->owner->id, 'device_id' => $this->device->id, 'body' => $this->input['message'], 'is_from_device' => 1]))
			{
				\Event::fire(new DeviceMadeUpdate($this->device->owner->id, $this->device->id, $this->input['message'],"landlord/device"));
				return 'success';
			}
			else
			{
				return 'failed';
			}
		}
	}

	public function updateRoutingId()
	{
		if($this->deviceIsValid($this->device))
		{
			$this->device->routing_id = $this->input['routing_id'];
			$this->device->save();
			return response()->json($this->device->routing_id);
		}
	}

	public function rentStatus()
	{
		return response()->json(['rent_amount' => $this->device->rent_amount, 'balance_due' => $this->device->balance_due]);
	}

	public function payRent()
	{
		if($this->deviceIsValid($this->device))
		{
			$this->input['amount'] = $this->input['payment_amount'];
			$response = $this->device->charge($this->input['amount'], $this->input);

			$transaction = Transaction::create(['amount' => $this->input['amount'], 'user_id' => $this->device->owner->id, 'payable_type' => 'device', 'payable_id' => $this->device->id, 'description' => 'Rent Payment', 'date' => date('Y-m-d', time())]);
			RentPayment::create(['user_id' => $this->device->owner->id, 'device_id' => $this->device->id, 'transaction_id' => $transaction->id, 'amount' => $this->input['payment_amount']]);
			return json_encode($response);
		}
		return json_encode(['errors', ['Something has gone wrong...']]);
	}

}  