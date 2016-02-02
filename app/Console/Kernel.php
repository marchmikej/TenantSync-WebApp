<?php

namespace App\Console;

use TenantSync\Models\Device;
use TenantSync\Models\RentBill;
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
        \App\Console\Commands\RefreshDevice::class,
        \App\Console\Commands\ChimeDevice::class,
        \App\Console\Commands\GenerateRentBills::class,
        \App\Console\Commands\UpdatePropertyValue::class,
        \App\Console\Commands\UpdateDeviceAlarms::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('command:GenerateRentBills')->everyMinute();
        $schedule->command('command:UpdatePropertyValue')->dailyAt('18:45');
        $schedule->command('command:UpdateDeviceAlarms')->dailyAt('18:44');
    }
}
