<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use TenantSync\Models\Property;
use TenantSync\Models\Device;
use TenantSync\Models\Invoice;

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
