<?php namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use DB;

class DeviceMadePayment extends Event {

	use SerializesModels;
	public $deviceId;
    public $propertyId;
    public $deviceName;
    public $deviceRoute;
    public $message;
    public $urlSend;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($deviceId)
    {
    	$deviceData = \DB::table('devices')
        	->where('id', '=', $deviceId)
        	->get();
        $this->propertyId = $deviceData[0]->property_id;
        $this->deviceName = $deviceData[0]->location;
        $this->deviceId = $deviceId;
        $this->message = "Device made payment ";
        $this->deviceRoute = $deviceData[0]->routing_id;
        $this->urlSend = "landlord/" . $deviceId;
    }

}
