<?php 

namespace App\Events;

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
        // if(is_array($deviceId)) {
        //     $this->route = Device::whereIn('id', $deviceId)->get()->pluck('routing_id')->toArray();
        // }

        $this->message = "NEWMESSAGE: " . $message;
    }

}
