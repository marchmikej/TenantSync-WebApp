<?php 

namespace Services;

class GoogleMessenger {
	
	public static function sendToDevice($device, $message, $urlSend = null)
	{
		$deviceTypes = [
		    0 => 'Iphone',
		    1 => 'Android',
		];
		
		$deviceType = $deviceTypes[$managerDevice->type];

		self::sendTo.$deviceType($device, $message, $urlSend);
	}

	public static function sendToIphone($iphone, $message, $urlSend)
    {
        // Put your device token here (without spaces):
        $deviceToken = $device_token = $device->routing_id;

        // Put your private key's passphrase here:
        $passphrase = env('APN_PASSPHRASE', "NONE");

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
            'url' => $urlSend,
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
    }

    public static function sendToAndriod($android, $message, $urlSend = null)
    {
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        // This is the identifier for our application
        $appId = "AIzaSyA7Bejrx8-rDGVvaPoVVXpXy1oxYTBn9Ug";

        // This will be unique for each device.  It will have to be stored in the database for each device
        // In theory it could change at any moment so we will need an API to update this through the 
        // device.  This token is the device I've been testing with.
        $device_token = $android->routing_id;

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