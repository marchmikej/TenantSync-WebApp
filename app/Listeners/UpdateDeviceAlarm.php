<?php

namespace App\Listeners;

use App\Events\UpdatedDeviceTransactions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateDeviceAlarm
{
    /**
     * Create the event listener.
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
     * @param  UpdatedDeviceTransactions  $event
     * @return void
     */
    public function handle(UpdatedDeviceTransactions $event)
    {
        $event->device->updateAlarm();
    }
}
