<?php namespace App\Listeners;

use DB;
use Mail;
use Services\GoogleMessenger;
use TenantSync\Models\Device;
use TenantSync\Models\Manager;
use TenantSync\Models\Property;
use App\Events\DeviceMadeUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

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
        // Get device that fired event 
        $device = Device::find($event->deviceId);
        
        $managers = $this->device->property->managers()
            ->whereHas('notifications', function($query) {
                $query->where(['name' => 'message_received']);
            })
            ->get();

        $data = [
            'manager' => $manager, 
            'event' => $event,
        ];

        // Send the notification via email, text, or both.
        $managers->each(function($manager) {
            if ($manager->email_notifications) {
                Mail::queue('emails.usersend', $data, function ($message) use ($device, $manager) {
                    $message->to($manager->email, $manager->last_name)
                            ->subject('Message from ' . $device->address);

<<<<<<< Updated upstream
                    $message->from('admin@tenantsync.com', 'TenantSync');
                });
=======
        for ($y = 0; $y < count($emails); $y++)
        {   
            $currentRow=$emails[$y];
            Mail::queue('emails.usersend', ['currentRow' => $currentRow, 'event' => $event], function ($m) use ($currentRow, $event) {
                $m->to($currentRow->email, $currentRow->last_name)->subject('Message from ' . $event->deviceName . " " . $currentRow->address);
                $m->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
            });
        }

        for ($x = 0; $x < count($users); $x++)
        {   
            // This is the message sent to the device
            $message = "MESSAGE: " . $event->message . " from " . $event->deviceName . " " . $users[$x]->address . " ENDMESSAGE URL: " . $event->urlSend;
            $iosMessage = $event->message . " from " . $event->deviceName . " " . $users[$x]->address;

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
                    'alert' => $iosMessage,
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
>>>>>>> Stashed changes
            }

            if ($manager->text_notifications) {
                $manager->devicesToNotify->each(function($managerDevice) use ($device, $manager, $event) {
                    $deviceTypes = [
                        0 => 'Iphone',
                        1 => 'Android',
                    ];

                    $deviceMessages = [
                        0 => $event->message . " from " . $device->address,
                        1 => "MESSAGE: " . $event->message . " from " . $device->address . " " ." ENDMESSAGE URL: " . $event->urlSend,
                    ];

                    $deviceType = $deviceTypes[$managerDevice->type];

                    $message = $deviceMessages[$managerDevice->type];

                    GoogleMessenger::sendToDevice($managerDevice, $message, $event->urlSend);
                });
            }
        });
    }

    // $users = DB::table('manager_property')
    //     ->where('manager_property.property_id', '=', $event->propertyId)
    //     ->where('manager_property.app_message', '=', 1)
    //     ->join('managers', 'manager_property.manager_id', '=', 'managers.id')
    //     ->join('landlord_devices', 'managers.user_id', '=', 'landlord_devices.user_id')
    //     ->join('properties', 'manager_property.property_id', '=', 'properties.id')
    //     ->join('users', 'managers.user_id', '=', 'users.id')
    //     ->select('managers.user_id', 'landlord_devices.routing_id', 'landlord_devices.type', 'properties.address', 'users.email', 'managers.last_name', 'managers.first_name')
    //     ->get();

    // $emails = DB::table('manager_property')
    //     ->where('manager_property.property_id', '=', $event->propertyId)
    //     ->where('manager_property.email_message', '=', 1)
    //     ->join('managers', 'manager_property.manager_id', '=', 'managers.id')
    //     ->join('properties', 'manager_property.property_id', '=', 'properties.id')
    //     ->join('users', 'managers.user_id', '=', 'users.id')
    //     ->select('managers.user_id', 'properties.address', 'users.email', 'managers.last_name', 'managers.first_name')
    //     ->get();

    // for ($y = 0; $y < count($emails); $y++)
    // {   
    //     $currentRow = $emails[$y];
    //     Mail::queue('emails.usersend', ['currentRow' => $currentRow, 'event' => $event], function ($m) use ($currentRow, $event) {
    //         $m->to($currentRow->email, $currentRow->last_name)->subject('Message from ' . $event->deviceName . " " . $currentRow->address);
    //         $m->from('admin@tenantsync.com', 'TenantSync');
    //     });
    // }

    // for ($x = 0; $x < count($users); $x++)
    // {   
    //     // This is the message sent to the device
    //     $message = "MESSAGE: " . $event->message . " from " . $event->deviceName . " " . $users[$x]->address . " ENDMESSAGE URL: " . $event->urlSend;
    //     $iosMessage = $event->message . " from " . $event->deviceName . " " . $users[$x]->address;

    //     // If type == 0 it is an iphone
    //     // If type == 1 it is an android
    //     if($users[$x]->type == 0) {
    //         // Put your device token here (without spaces):
    //         $deviceToken = $device_token=$users[$x]->routing_id;

    //         // Put your private key's passphrase here:
    //         $passphrase = env('APN_PASSPHRASE', "NONE");

    //         // Put your alert message here:
    //         $message = $event->message;

    //         ////////////////////////////////////////////////////////////////////////////////
    //         $ctx = stream_context_create();
    //         stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
    //         stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    //         // Open a connection to the APNS server
    //         $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,
    //         $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    //         if (!$fp)
    //             exit("Failed to connect: $err $errstr" . PHP_EOL);

    //         echo 'Connected to APNS' . PHP_EOL;

    //         // Create the payload body
    //         $body['aps'] = array(
    //             'alert' => $iosMessage,
    //             'badge' => 1,
    //             'url' => $event->urlSend,
    //             'sound' => 'default'
    //         );

    //         // Encode the payload as JSON
    //         $payload = json_encode($body);

    //         // Build the binary notification
    //         $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

    //         // Send it to the server
    //         $result = fwrite($fp, $msg, strlen($msg));

    //         if (!$result)
    //             echo 'Message not delivered' . PHP_EOL;
    //         else
    //             echo 'Message successfully delivered' . PHP_EOL;

    //         // Close the connection to the server
    //         fclose($fp);
    //     } else if($users[$x]->type == 1) {
    //         $url = 'https://gcm-http.googleapis.com/gcm/send';

    //         // This is the identifier for our application
    //         $appId = "AIzaSyA7Bejrx8-rDGVvaPoVVXpXy1oxYTBn9Ug";

    //         // This will be unique for each device.  It will have to be stored in the database for each device
    //         // In theory it could change at any moment so we will need an API to update this through the 
    //         // device.  This token is the device I've been testing with.
    //         $device_token=$users[$x]->routing_id;
    //         $push_payload = json_encode(array(
    //             "data" => array(
    //                     "message" => $message,
    //                 ),
    //             "to" => $device_token
    //         ));

    //         $rest = curl_init();
    //         curl_setopt($rest,CURLOPT_URL,$url);
    //         curl_setopt($rest,CURLOPT_PORT,443);
    //         curl_setopt($rest,CURLOPT_POST,1);
    //         curl_setopt($rest,CURLOPT_POSTFIELDS,$push_payload);
    //         curl_setopt($rest,CURLOPT_HTTPHEADER,
    //         array("Authorization:key=" . $appId,
    //                 "Content-Type: application/json"));

    //         $response = curl_exec($rest);
    //     }
    // }
}
