<?php namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager as Auth;
use Illuminate\Http\Request;
use App\Events\DeviceUpdateMaintenance;
use TenantSync\Models\Device;
use TenantSync\Models\OverdueUsage;
use TenantSync\Models\OverdueType;
use TenantSync\Models\Property;
use TenantSync\Models\User;
use TenantSync\Mutators\PropertyMutator;
use Response;

class ReportController extends Controller {

	public function __construct(Request $request)
	{
		parent::__construct();
	}

	public function index()
	{
		return view('TenantSync::landlord/reports/index');
	}

	public function overdueUsage() 
	{
		$devices = $this->user->devices;
		$content="device_id,location,address,city,state,zip,interaction,time\n";
		//This for loop goes through each of the landlords devices
        for ($x = 0; $x < count($devices); $x++)
        {
            $currentDevice=$devices[$x];
			$overdueUsage = OverdueUsage::where('device_id', '=', $currentDevice->id)->get();
			//This for loop goes through each devices overdue usage
		    for ($y = 0; $y < count($overdueUsage); $y++)
		    {
		       	$currentDevice=Device::find($overdueUsage[$y]->device_id);
	         	$currentType=OverdueType::find($overdueUsage[$y]->overdue_type_id);
	          	$content = $content . $currentDevice["id"] . "," . $currentDevice["location"] . "," . $currentDevice->property->address . "," . $currentDevice->property->city . "," . $currentDevice->property->state . "," . $currentDevice->property->zip . "," . $currentType->overdue_description . "," . $overdueUsage[$y]->created_at . "\n";
		    }
		}
		
       	return Response::make($content, '200', array(
    		'Content-Type' => 'application/octet-stream',
    		'Content-Disposition' => 'attachment; filename="TenantSyncOverdueUsage.csv"'
		));
	}

	public function printMyDevices()
	{
		$devices = $this->user->devices;
		$content ="device_id,serial,location,property,city,state,zip,rent_amount,late_fee,rent_owed\n";

		if(count($devices) > 0) 
        {
            for ($y = 0; $y < count($devices); $y++)
            {
            	$currentDevice=$devices[$y];
            	$content = $content . $currentDevice["id"] . "," . $currentDevice["serial"] . "," . $currentDevice["location"] . "," . $currentDevice->property->address . "," . $currentDevice->property->city . "," . $currentDevice->property->state . "," . $currentDevice->property->zip . "," . $currentDevice["rent_amount"] . "," . $currentDevice["late_fee"] . "," . $currentDevice->rentOwed() . "\n";
            }
        }

		// return an string as a file to the user
		return Response::make($content, '200', array(
    		'Content-Type' => 'application/octet-stream',
    		'Content-Disposition' => 'attachment; filename="TenantSyncDevices.csv"'
		)); 
	}

	public function test()
    {
    	/*
    	$device=Device::find(73);
    	
    	if($device->alarm_id > 0) {
	    	OverdueUsage::create([
				'device_id' => $device->id, 
				'overdue_types_id' => 5
			]);
	    } */
	    $overdueUsage = OverdueUsage::where('device_id', '=', 73)->get();
	    //$overdueType = OverdueType::find($overdueType->overdue_types_id);
	    echo "device_id,location,address,city,state,zip,interaction,time\n</br>";
        for ($y = 0; $y < count($overdueUsage); $y++)
        {
          	$currentDevice=Device::find($overdueUsage[$y]->device_id);
          	$currentType=OverdueType::find($overdueUsage[$y]->overdue_type_id);
          	$content = $currentDevice["id"] . "," . $currentDevice["location"] . "," . $currentDevice->property->address . "," . $currentDevice->property->city . "," . $currentDevice->property->state . "," . $currentDevice->property->zip . "," . $currentType->overdue_description . "," . $overdueUsage[$y]->created_at . "\n";
          	echo $content . "</br>";
        }
    	// return an string as a file to the user
		return Response::make($content, '200', array(
    		'Content-Type' => 'application/octet-stream',
    		'Content-Disposition' => 'attachment; filename="TenantSyncDevices.csv"'
		));
    	/*  This is for dowloading a csv file 
		$devices = Device::all();
		$content ="device_id,location,property,city,state,zip,rent_amount,late_fee,rent_owed\n";

		if(count($devices) > 0) 
        {
            for ($y = 0; $y < count($devices); $y++)
            {
            	$currentDevice=$devices[$y];
            	$content = $content . $currentDevice["id"] . "," . $currentDevice["location"] . "," . $currentDevice->property->address . "," . $currentDevice->property->city . "," . $currentDevice->property->state . "," . $currentDevice->property->zip . "," . $currentDevice["rent_amount"] . "," . $currentDevice["late_fee"] . "," . $currentDevice->rentOwed() . "\n";
            }
        }

		// return an string as a file to the user
		return Response::make($content, '200', array(
    		'Content-Type' => 'application/octet-stream',
    		'Content-Disposition' => 'attachment; filename="TenantSyncDevices.csv"'
));   */
/*        $file= public_path(). "/images/app-debug.apk";

    	$headers = array(
        	'Content-Type: application/vnd.android.package-archive',
        );
        
        $file = \File::get($file);
    	
	    $response = \Response::make($file, 200);

	    return $response;
    	// return response()->download($file, 'app-debug.apk', $headers);
*/
    }

}  
