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
        
        // Get all the managers that need to be notified
        $managers = $this->device->property->managers()
            ->whereHas('notifications', function($query) {
                $query->where(['name' => 'rent_payment_received']);
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
                            ->subject('Payment received from ' . $device->address);

                    $message->from('admin@tenantsync.com', 'TenantSync');
                });
            }

            if ($manager->text_notifications) {
                $manager->devicesToNotify->each(function($managerDevice) use ($device, $manager, $event) {
                    $deviceMessages = [
                        0 => "You missed a payment from  " . $device->address,
                        1 => "MESSAGE: Payment received from " . $device->address . " ENDMESSAGE URL: https://app.tenantsync.com",
                    ];

                    $message = $deviceMessages[$managerDevice->type];

                    GoogleMessenger::sendToDevice($managerDevice, $message, $event->urlSend);
                });
            }
        });
    }
}
