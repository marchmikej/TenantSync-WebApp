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
        $deviceData = \DB::table('devices')
        ->where('id', '=', $deviceId)
        ->get();

        $users = DB::table('manager_property')
            ->where('manager_property.property_id', '=', $deviceData[0]->property_id)
            ->join('managers', 'manager_property.manager_id', '=', 'managers.id')
            ->join('landlord_devices', 'managers.user_id', '=', 'landlord_devices.user_id')
            ->select('managers.user_id', 'landlord_devices.routing_id')
            ->get();

        // This is the message sent to the device
        $message = "MESSAGE: " . $event->message . " ENDMESSAGE URL: " . $event->urlSend;

        for ($x = 0; $x < count($users); $x++)  
        {
            // If type == 0 it is an iphone
            // If type == 1 it is an android
            if($users[$x]->type == 0) {
                // Put your device token here (without spaces):
                $deviceToken = $device_token=$users[$x]->routing_id;

                // Put your private key's passphrase here:
                $passphrase = env('APN_PASSPHRASE', "NONE");

                // Put your alert message here:
                $message = $event->message;

                ////////////////////////////////////////////////////////////////////////////////
                $ctx = stream_context_create();
                stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
                stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

                // Open a connection to the APNS server
                $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

                if (!$fp)
                    exit("Failed to connect: $err $errstr" . PHP_EOL);

                echo 'Connected to APNS' . PHP_EOL;

                // Create the payload body
                $body['aps'] = array(
                    'alert' => $message,
                    'badge' => 1,
                    'url' => $event->urlSend,
                    'sound' => 'default'
                );

                // Encode the payload as JSON
                $payload = json_encode($body);

                // Build the binary notification
                $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));

                if (!$result)
                    echo 'Message not delivered' . PHP_EOL;
                else
                    echo 'Message successfully delivered' . PHP_EOL;

                // Close the connection to the server
                fclose($fp);
            } else if($users[$x]->type == 1) {
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
}
