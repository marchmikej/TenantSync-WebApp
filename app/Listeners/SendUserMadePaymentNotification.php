<?php namespace App\Listeners;

use DB;
use Mail;
use Services\GoogleMessenger;
use App\Events\DeviceMadePayment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendUserMadePaymentNotification {

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
	public function handle(DeviceMadePayment $event)
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
            if ($currentRow->text_notifications && $currentRow->cell_carrier_id > 0)
            {
                $users = DB::table('cell_carriers')->where('id', '=', $currentRow->cell_carrier_id)->get();
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
}
