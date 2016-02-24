<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use TenantSync\Models\Property;
use TenantSync\Models\Device;
use DB;

class UnPinDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UnPinDevice {deviceId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will cause a device to leave kiosk mode/unpin application.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $deviceId = $this->argument('deviceId');
        $route = Device::where(['id' => $deviceId])->first()->routing_id;

        $message = "UNPINDEVICE:";
        //
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        // This is the identifier for our application
        $appId = "AIzaSyCsP0g5eT8-FHGWb8fWfQyNALURHJO1G2Q";

        // This will be unique for each device.  It will have to be stored in the database for each device
        // In theory it could change at any moment so we will need an API to update this through the 
        // device.  This token is the device I've been testing with.
        // var_export($event->route);die();
        $device_token = $route;
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
        return;
    }
}