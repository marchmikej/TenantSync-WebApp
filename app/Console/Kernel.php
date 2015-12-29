<?php

namespace App\Console;

use TenantSync\Models\Device;
use TenantSync\Models\Invoice;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() 
        {
            $this->generateRentBills();
        }
        )->daily();
    }

    public function generateRentBills()
    {
        $devices = Device::all();
        $devicesToBill = $devices->filter(function($device) 
        {
            return date('m-d', strtotime($device->rent_due_date)) == date('m-d', time());
        });
        foreach($devicesToBill as $device)
        {
            $bill = Invoice::create(['user_id' => $device->owner->id, 'device_id' => $device->id, 'billing_month' => date('m', time()), 'billing_year' => date('Y', time()), 'amount' => $device->rent_amount]);
            
            if($device->vacant)
            {
                $bill->vacant = 1;
                $bill->save();
            } 

            $device->rent_due_date = date('Y-m-d', strtotime($device->rent_due_date) + strtotime('+30 days'));
            if(! date('m', strtotime($device->rent_due_date) + strtotime('+1 month')) == date('m', strtotime($device->rent_due_date)))
            {
                $device->rent_due_date = date('Y-m-d', strtotime($device->rent_due_date) + strtotime('last day of +1 month'));
            }
            $device->save();
        }
    }
}
