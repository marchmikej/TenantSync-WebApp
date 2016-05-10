<?php namespace App\Listeners;

use DB;
use Mail;
use App\Events\DeviceRefresh;
use Services\GoogleMessenger;
use App\Events\DeviceMissedPayment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendUserMissedPaymentNotification {

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
	public function handle(DeviceMissedPayment $event)
    {
        // Get device that fired event 
        $device = Device::find($event->deviceId);
        
        $managers = $device->property->managers()->get();

        for ($y = 0; $y < count($managers); $y++)
        {
            $currentRow=$managers[$y];
            // This is for email notifications
            if ($currentRow->email_notifications)
            {
                $data = array("deviceId"=>$event->deviceId, "email"=>$currentRow->email(), "name"=>$currentRow->last_name, "message"=>$event->message, "property"=>$device->address);
                if($currentRow->position == "Landlord") {
                    Mail::raw($data['message'] . "\n" . env('URL_BASE', 'https://portal.tenantsync.com') . "/landlord/device/" . $data['deviceId'],  function ($message) use ($data) {
                        $message->to($data['email'],$data['name'])
                            ->subject('Message received from ' . $data['property']);

                        $message->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
                    });
                }
                else
                {
                    Mail::raw($data['message'] . "\n" . env('URL_BASE', 'https://portal.tenantsync.com') . "/manager/device/" . $data['deviceId'],  function ($message) use ($data) {
                        $message->to($data['email'],$data['name'])
                            ->subject('Message received from ' . $data['property']);
                        $message->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
                    });
                }
            }

            // This is for email text
            if ($currentRow->text_notifications && $currentRow->cell_carrier > 0)
            {
                $users = DB::table('cell_carriers')->where('id', '=', $currentRow->cell_carrier)->get();
                $phone = $currentRow->phone . "@" . $users[0]->email_suffix;
                $data = array("deviceId"=>$event->deviceId, "email"=>$phone, "name"=>$currentRow->last_name, "message"=>$event->message, "property"=>$device->address);
                if($currentRow->position == "Landlord") {
                    Mail::raw($data['message'] . "\n" . env('URL_BASE', 'https://portal.tenantsync.com') . "/landlord/device/" . $data['deviceId'],  function ($message) use ($data) {
                        $message->to($data['email'],$data['name'])
                            ->subject('Message received from ' . $data['property']);

                        $message->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
                    });
                }
                else
                {
                    Mail::raw($data['message'] . "\n" . env('URL_BASE', 'https://portal.tenantsync.com') . "/manager/device/" . $data['deviceId'],  function ($message) use ($data) {
                        $message->to($data['email'],$data['name'])
                            ->subject('Message received from ' . $data['property']);
                        $message->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
                    });
                }
            }
        }
    }

    //     \Event::fire(new DeviceRefresh($event->deviceId));
    //     $users = DB::table('manager_property')
    //         ->where('manager_property.property_id', '=', $event->propertyId)
    //         ->where('manager_property.app_missed_payment', '=', 1)
    //         ->join('managers', 'manager_property.manager_id', '=', 'managers.id')
    //         ->join('user_devices', 'managers.user_id', '=', 'user_devices.user_id')
    //         ->join('properties', 'manager_property.property_id', '=', 'properties.id')
    //         ->join('users', 'managers.user_id', '=', 'users.id')
    //         ->select('managers.user_id', 'user_devices.routing_id', 'user_devices.type', 'properties.address', 'users.email', 'managers.last_name', 'managers.first_name')
    //         ->get();
    //     $emails = DB::table('manager_property')
    //         ->where('manager_property.property_id', '=', $event->propertyId)
    //         ->where('manager_property.email_missed_payment', '=', 1)
    //         ->join('managers', 'manager_property.manager_id', '=', 'managers.id')
    //         ->join('properties', 'manager_property.property_id', '=', 'properties.id')
    //         ->join('users', 'managers.user_id', '=', 'users.id')
    //         ->select('managers.user_id', 'properties.address', 'users.email', 'managers.last_name', 'managers.first_name')
    //         ->get();

    //     for ($y = 0; $y < count($emails); $y++)
    //     {   
    //         $currentRow=$emails[$y];
    //         Mail::queue('emails.usersend', ['currentRow' => $currentRow, 'event' => $event], function ($m) use ($currentRow, $event) {
    //             $m->to($currentRow->email, $currentRow->last_name)->subject('Missed payment from ' . $event->deviceName . " " . $currentRow->address);
    //             $m->from('admin@tenantsync.com', 'TenantSync');
    //         });
    //     }

    //     for ($x = 0; $x < count($users); $x++)
    //     {   
    //         // This is the message sent to the device
    //         $message = "MESSAGE: Missed payment from " . $event->deviceName . " " . $users[$x]->address . " ENDMESSAGE URL: https://app.tenantsync.com";
    //         $iosMessage = "You missed a payment from  " . $event->deviceName . " " . $users[$x]->address;

    //         // If type == 0 it is an iphone
    //         // If type == 1 it is an android
    //         if($users[$x]->type == 0) {
    //             // Put your device token here (without spaces):
    //             $deviceToken = $device_token=$users[$x]->routing_id;

    //             // Put your private key's passphrase here:
    //             $passphrase = env('APN_PASSPHRASE', "NONE");

    //             // Put your alert message here:
    //             $message = $event->message;

    //             ////////////////////////////////////////////////////////////////////////////////
    //             $ctx = stream_context_create();
    //             stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
    //             stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

    //             // Open a connection to the APNS server
    //             $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,
    //             $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

    //             if (!$fp)
    //                 exit("Failed to connect: $err $errstr" . PHP_EOL);

    //             echo 'Connected to APNS' . PHP_EOL;

    //             // Create the payload body
    //             $body['aps'] = array(
    //                 'alert' => $iosMessage,
    //                 'badge' => 1,
    //                 'url' => "https://app.tenantsync.com",
    //                 'sound' => 'default'
    //             );

    //             // Encode the payload as JSON
    //             $payload = json_encode($body);

    //             // Build the binary notification
    //             $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

    //             // Send it to the server
    //             $result = fwrite($fp, $msg, strlen($msg));

    //             if (!$result)
    //                 echo 'Message not delivered' . PHP_EOL;
    //             else
    //                 echo 'Message successfully delivered' . PHP_EOL;

    //             // Close the connection to the server
    //             fclose($fp);
    //         } else if($users[$x]->type == 1) {
    //             $url = 'https://gcm-http.googleapis.com/gcm/send';

    //             // This is the identifier for our application
    //             $appId = "AIzaSyA7Bejrx8-rDGVvaPoVVXpXy1oxYTBn9Ug";

    //             // This will be unique for each device.  It will have to be stored in the database for each device
    //             // In theory it could change at any moment so we will need an API to update this through the 
    //             // device.  This token is the device I've been testing with.
    //             $device_token=$users[$x]->routing_id;
    //             $push_payload = json_encode(array(
    //                 "data" => array(
    //                         "message" => $message,
    //                     ),
    //                 "to" => $device_token
    //             ));

    //             $rest = curl_init();
    //             curl_setopt($rest,CURLOPT_URL,$url);
    //             curl_setopt($rest,CURLOPT_PORT,443);
    //             curl_setopt($rest,CURLOPT_POST,1);
    //             curl_setopt($rest,CURLOPT_POSTFIELDS,$push_payload);
    //             curl_setopt($rest,CURLOPT_HTTPHEADER,
    //             array("Authorization:key=" . $appId,
    //                     "Content-Type: application/json"));

    //             $response = curl_exec($rest);
    //         }
    //     }
    // }
}
