<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\MessageCreatedByUser' => [
            'App\Listeners\SendNewMessageNotification',
        ],
        'App\Events\LandlordRespondedToMaintenance' => [
            'App\Listeners\SendDeviceMessageNotification',
        ],
        'App\Events\DeviceMadeUpdate' => [
            'App\Listeners\SendUserMessageNotification',
        ],
        'App\Events\DeviceRefresh' => [
            'App\Listeners\RefreshDevice',
        ],
        'App\Events\DeviceChime' => [
            'App\Listeners\SendDeviceChimeNotification',
        ],
        'App\Events\DeviceMissedPayment' => [
            'App\Listeners\SendUserMissedPaymentNotification',
        ],
        'App\Events\DeviceMadePayment' => [
            'App\Listeners\SendUserMadePaymentNotification',
        ],
        'App\Events\UpdatedDeviceTransactions' => [
            'App\Listeners\UpdateDeviceAlarm',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
