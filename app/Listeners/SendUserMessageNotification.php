<?php namespace App\Listeners;

use App\Events\DeviceMadeUpdate;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use DB;

class SendUserMessageNotification {

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
	 * @param  DeviceMadeUpdate  $event
	 * @return void
	 */
	public function handle(DeviceMadeUpdate $event)
    {
        $users = \DB::table('landlord_devices')
        ->where('user_id', '=', $event->userId)
        ->get();

        // This is the message sent to the device
        $message = "MESSAGE: " . $event->message . " ENDMESSAGE URL: " . $event->urlSend;

        for ($x = 0; $x < count($users); $x++)  
        {
            //
            $url = 'https://gcm-http.googleapis.com/gcm/send';

            // This is the identifier for our application
            $appId = "AIzaSyA7Bejrx8-rDGVvaPoVVXpXy1oxYTBn9Ug";

            // This will be unique for each device.  It will have to be stored in the database for each device
            // In theory it could change at any moment so we will need an API to update this through the 
            // device.  This token is the device I've been testing with.
            $device_token=$users[$x]->routing_id;
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
            curl_setopt($rest,CURLOPT_POSTFIELDS,$push_payload);
            curl_setopt($rest,CURLOPT_HTTPHEADER,
            array("Authorization:key=" . $appId,
                    "Content-Type: application/json"));

            $response = curl_exec($rest);
        }
    }

}
