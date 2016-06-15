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

        $notification = DB::table('notifications')->where('name', '=', 'rent_payment_received')->get();
        // If the message_received exists in notifications table we can proceed
        if(count($notification) > 0) 
        {
            for ($y = 0; $y < count($managers); $y++)
            {
                $currentManager=$managers[$y];

                //If a row exists here then the manager has selected to receive this type of notification
                $shouldNotify = DB::table('manager_notification')
                    ->where('notification_id', '=', $notification[0]->id)
                    ->where('manager_id', '=', $currentManager->id)
                    ->get();

                // This is for email notifications
                if ($currentManager->email_notifications && count($shouldNotify) > 0)
                {
                    $data = array("deviceId"=>$event->deviceId, "email"=>$currentManager->email(), "name"=>$currentManager->last_name, "message"=>$event->message, "property"=>$device->address);
                    if($currentManager->position == "Landlord") {
                        Mail::raw($data['message'] . "\n" . env('URL_BASE', 'https://portal.tenantsync.com') . "/landlord/device/" . $data['deviceId'],  function ($message) use ($data) {
                            $message->to($data['email'],$data['name'])
                                ->subject('Payment from ' . $data['property']);

                            $message->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
                        });
                    }
                    else
                    {
                        Mail::raw($data['message'] . "\n" . env('URL_BASE', 'https://portal.tenantsync.com') . "/manager/device/" . $data['deviceId'],  function ($message) use ($data) {
                            $message->to($data['email'],$data['name'])
                                ->subject('Payment from ' . $data['property']);
                            $message->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
                        });
                    }
                }

                // This is for email text
                if ($currentManager->text_notifications && $currentManager->cell_carrier_id > 0 && count($shouldNotify) > 0)
                {
                    $users = DB::table('cell_carriers')->where('id', '=', $currentManager->cell_carrier_id)->get();
                    $phone = $currentManager->phone . "@" . $users[0]->email_suffix;
                    $data = array("deviceId"=>$event->deviceId, "email"=>$phone, "name"=>$currentManager->last_name, "message"=>$event->message, "property"=>$device->address);
                    if($currentManager->position == "Landlord") {
                        Mail::raw($data['message'] . "\n" . env('URL_BASE', 'https://portal.tenantsync.com') . "/landlord/device/" . $data['deviceId'],  function ($message) use ($data) {
                            $message->to($data['email'],$data['name'])
                                ->subject('Payment from ' . $data['property']);

                            $message->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
                        });
                    }
                    else
                    {
                        Mail::raw($data['message'] . "\n" . env('URL_BASE', 'https://portal.tenantsync.com') . "/manager/device/" . $data['deviceId'],  function ($message) use ($data) {
                            $message->to($data['email'],$data['name'])
                                ->subject('Payment from ' . $data['property']);
                            $message->from(env('SEND_EMAIL', 'admin@tenantsyncdev.com'), 'TenantSync');
                        });
                    }
                }
            }
        }
    }
}
