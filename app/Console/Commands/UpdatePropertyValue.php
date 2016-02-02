<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use TenantSync\Models\Property;
use DB;

class UpdatePropertyValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdatePropertyValue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command retrieves all of the properties in the database and updates their Zillow property value';

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
        \Log::info('Running UpdatePropertyValue: ');

        $sms1day = DB::table('properties')->get();

        for ($x = 0; $x < count($sms1day); $x++)  
        {
            $currentRow=$sms1day[$x];
            $address = $currentRow->address;
            //replace spaces with + sign
            $address = str_replace(' ', '+', $address);
            $city = $currentRow->city;
            //replace spaces with + sign
            $city = str_replace(' ', '+', $city); 
            $state = $currentRow->state;
            //replace spaces with + sign
            $state = str_replace(' ', '+', $state);
            $zip =  $currentRow->zip;
    
            //$url = "http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=X1-ZWz1a3p9wlpzij_1u0pu&address=6530+Belle+Way&citystatezip=Clarence+NY+14051";
            $url = "http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=X1-ZWz1a3p9wlpzij_1u0pu&address=" . $address . "&citystatezip=" . $city . "+" . $state . "+" . $zip;
    
            $data = simplexml_load_string(file_get_contents($url));
            $result = (string) $data->message->code;
    
            if($result == 0){
                //found 
                $zestimateint = (int) $data->response->results->result->zestimate->amount;

                if($zestimateint <> $currentRow->value) {   
                    DB::table('properties')
                        ->where('id', $currentRow->id)
                        ->update(
                            ['value' => $zestimateint
                    ]);
                }

            } else {
                //nothing found
            }
        }
    }
}
