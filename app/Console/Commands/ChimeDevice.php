<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use TenantSync\Models\Property;
use App\Events\DeviceChime;
use DB;

class ChimeDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ChimeDevice {deviceId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will cause a device in the main screen to omit a chime.';

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
        $deviceId = $this->argument('deviceId');
        \Event::fire(new DeviceChime($deviceId));
        return;
    }
}