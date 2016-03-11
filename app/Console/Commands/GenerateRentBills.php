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

        foreach($devices as $device) {
            if($this->deviceHasNotBeenBilled($device)) {
                $this->createNewBillForDevice($device);
            }
        }
    }

    public function deviceHasNotBeenBilled($device)
    {
        $latestBill = RentBill::where(['device_id' => $device->id])->orderBy('created_at', 'desc')->first();

        $latestBillMonth = date('m', strtotime($latestBill->rent_month));

        return $latestBillMonth < date('m');
    }

    public function createNewBillForDevice($device)
    {
        $bill = RentBill::create([
            'user_id' => $device->owner->id,
            'device_id' => $device->id, 
            'rent_month' => date('Y-m-d', strtotime('first day of this month')), 
            'bill_amount' => $device->rent_amount, 
            'vacant' => $device->vacant
        ]);

        $device->rent_due = date('Y-m-d', strtotime($device->rent_due. ' first day of +1 month'));

        $device->save();
    }
}
