<?php 

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use App\Events\DeviceRefresh;

class RefreshDevice {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  MessageCreatedByUser  $event
	 * @return void
	 */
	public function handle(DeviceRefresh $event)
    {
        //
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        // This is the identifier for our application
        $appId = "AIzaSyCsP0g5eT8-FHGWb8fWfQyNALURHJO1G2Q";
        
        // This is the message sent to the device
        $message = $event->message;

        // This will be unique for each device.  It will have to be stored in the database for each device
        // In theory it could change at any moment so we will need an API to update this through the 
        // device.  This token is the device I've been testing with.
        // var_export($event->route);die();
        $device_token = $event->route;
        $push_payload = json_encode(array(
            "data" => array(
                    "message" => $message,
                   ),
            "to" => $device_token
            ));

        $rest = curl_init();
        curl_setopt($rest,CURLOPT_URL,$url);
        curl_setopt($rest,CURLOPT_PORT,443);
        curl_setopt($rest,CURLOPT_POST,1);
        curl_setopt($rest,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($rest,CURLOPT_POSTFIELDS,$push_payload);
        curl_setopt($rest,CURLOPT_HTTPHEADER,
        array("Authorization:key=" . $appId,
                "Content-Type: application/json"));

        $response = curl_exec($rest);
        return true;
    }
}