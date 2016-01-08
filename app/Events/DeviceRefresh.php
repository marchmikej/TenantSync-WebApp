<?php

namespace App\Events;

use App\Events\Event;
use TenantSync\Models\Device;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeviceRefresh extends Event
{
    use SerializesModels;

    public $route;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($deviceId)
    {
        $this->route = Device::where(['id' => $deviceId])->first()->routing_id;
        $this->message = "REFRESH: REFRESH";
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
