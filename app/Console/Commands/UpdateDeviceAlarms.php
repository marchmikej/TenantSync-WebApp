<?php

namespace App\Console\Commands;

use TenantSync\Models\Device;
use TenantSync\Models\RentBill;
use Illuminate\Console\Command;

class UpdateDeviceAlarms extends Command
{
     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateDeviceAlarms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update device alarms that are deliquent.';

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
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Running UpdateDeviceAlarms: \n');
        echo ('Running UpdateDeviceAlarms:');

        $devices = Device::all();

        $deliquentDevices = array();

        foreach($devices as $device) {
            $balance = $device->balance();

            if($balance > 0) {
                $latestBill = $device->rentBills()->orderBy('created_at', 'desc')->first();

                if($balance > $latestBill->bill_amount) {
                    array_push($deliquentDevices, $device->id);
                    continue;
                }

                // If it is past the grace period and there is a balance
                // the device is deliquent
                if(strtotime($latestBill->rent_month. ' + ' .$device->grace_period. ' days') < time()) {
                    array_push($deliquentDevices, $device->id);
                }
            }
        }

        Device::whereIn('id', $deliquentDevices)->update(['alarm_id' => 1]);

        Device::whereNotIn('id', $deliquentDevices)->update(['alarm_id' => 0]);
    }
}
