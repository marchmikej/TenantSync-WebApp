<?php

namespace App\Console\Commands;

use TenantSync\Models\Device;
use TenantSync\Models\RentBill;
use TenantSync\Models\Property;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Mail;

class GenerateRentBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GenerateRentBills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates the billing cycle for the day';

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
        \Log::info('Running GenerateRentBills: ');

        $devices = Device::all();
        $devicesToBill = $devices->filter(function($device) 
        {
            if($device->rent_due != '0000-00-00') {
                return date('Y-m-d', strtotime($device->rent_due)) == date('Y-m-d', time());
            }
            return false;
        });
        foreach($devicesToBill as $device)
        {
            $bill = RentBill::create(['user_id' => $device->owner->id, 'device_id' => $device->id, 'rent_month' => date('Y-m-d', time()), 'bill_amount' => $device->rent_amount, 'balance_due' => $device->rent_amount, 'paid' => 0, 'vacant' => $device->vacant]);
            $device->rent_due = date('Y-m-d', strtotime($device->rent_due. ' +1 month'));
            // if(date('m', strtotime($device->rent_due) + strtotime('+1 month')) !== date('m', strtotime($device->rent_due)))
            // {
            //     $device->rent_due = date('Y-m-d', strtotime($device->rent_due) + strtotime('last day of +1 month'));
            // }

            $device->save();
        }

        // $data = array();
        // Mail::send('emails.processran', $data, function($message) {
        //     $message->to('marchmikej@gmail.com', 'Code Ran')->subject('GenerateRentBills Ran');
        //     $message->from('admin@tenantsync.com', 'TenantSync');
        // });
        // Mail::send('emails.processran', $data, function($message) {
        //     $message->to('mitchjam1928@gmail.com', 'Code Ran')->subject('GenerateRentBills Ran');
        //     $message->from('admin@tenantsync.com', 'TenantSync');
        // });
        return 'Finished';
    }
}
