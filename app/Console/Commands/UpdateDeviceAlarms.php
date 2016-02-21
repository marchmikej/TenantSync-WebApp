<?php

namespace App\Console\Commands;

use TenantSync\Models\Device;
use TenantSync\Models\RentBill;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateDeviceAlarms extends Command implements SelfHandling
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

        $devices = Device::all();

        $deliquentDevices = array();

        foreach($devices as $device) {
            $balance = $device->balance();

            if($balance < 0) {
                continue;
            }

            $latestBill = RentBill::where(['device_id' => $device->id])->orderBy('created_at', 'desc')->first();

            if(strtotime($latestBill->rent_month. ' + ' .$device->grace_period. ' days') < time()) {
                array_push($deliquentDevices, $device->id);
            }
        }

        Device::whereIn('id', $deliquentDevices)->update(['alarm_id' => 1]);

        Device::whereNotIn('id', $deliquentDevices)->update(['alarm_id' => 0]);

        // $data = array();
        // \Mail::send('emails.processran', $data, function($message) {
        //     $message->to('marchmikej@gmail.com', 'Code Ran')->subject('UpdateDeviceAlarms Ran');
        //     $message->from('admin@tenantsync.com', 'TenantSync');
        // });
        // \Mail::send('emails.processran', $data, function($message) {
        //     $message->to('mitchjam1928@gmail.com', 'Code Ran')->subject('UpdateDeviceAlarms Ran');
        //     $message->from('admin@tenantsync.com', 'TenantSync');
        // });
    }
}
