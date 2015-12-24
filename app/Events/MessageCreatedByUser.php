<?php namespace App\Events;

use App\Events\Event;
use TenantSync\Models\Device;
use Illuminate\Queue\SerializesModels;

class MessageCreatedByUser extends Event {

	use SerializesModels;

	public $route;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($deviceId, $message)
    {
        $this->route = Device::where(['id' => $deviceId])->first()->routing_id;
        $this->message = "NEWMESSAGE: " . $message;
    }

}
