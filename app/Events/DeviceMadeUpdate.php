<?php namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use DB;

class DeviceMadeUpdate extends Event {

	use SerializesModels;
	public $userId;
	public $deviceId;
	public $propertyId;
	public $deviceName;
    public $message;
    public $urlSend;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($userId, $deviceId, $message, $urlSend)
    {
    	$deviceData = \DB::table('devices')
        	->where('id', '=', $deviceId)
        	->get();
        $this->propertyId = $deviceData[0]->property_id;
        $this->deviceName = $deviceData[0]->location;
        $this->userId = $userId;
        $this->deviceId = $deviceId;
        $this->message = $message;
        $this->urlSend = $urlSend . "/" . $deviceId;
    }

}
