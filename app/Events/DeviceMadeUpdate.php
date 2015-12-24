<?php namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class DeviceMadeUpdate extends Event {

	use SerializesModels;
	public $userId;
	public $deviceId;
    public $message;
    public $urlSend;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($userId, $deviceId, $message, $urlSend)
    {
        $this->userId = $userId;
        $this->deviceId = $deviceId;
        $this->message = $message;
        $this->urlSend = $urlSend . "/" . $deviceId;
    }

}
