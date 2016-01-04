<?php namespace App\Http\Controllers\Sales;

use TenantSync\Models\User;
use TenantSync\Models\Device;
use TenantSync\Models\Property;
use App\Http\Controllers\Sales\BaseController;

class DeviceController extends SalesController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$devices = Device::all();
		return view('TenantSync::sales.device.index', compact('devices'));
	}

	public function create()
	{
		$landlord = User::find($this->input['user_id']);
		return view('TenantSync::sales.device.create', compact('landlord'));
	}

	public function store()
	{
		$this->input['token'] = \Token::create();
		$device = Device::create($this->input);

		//$device->owner->addDevice($device); 
		//get customer, specifically their next reacurring charge date
		//subtract todays date from that date
		//get the percentage of the month left
		//charge that percentage of the cost of the device per month
		
		//return view('TenantSync::sales.device.show', compact('device'));
		return redirect()->route('sales.landlord.show', [$this->input['user_id']]);
	}

	public function show($id)
	{
		$device = Device::find($id);
		return view('TenantSync::sales.device.show', compact('device'));
	}

	public function edit($id)
	{
		$device = Device::find($id);
		return view('TenantSync::sales.device.edit', compact('device'));
	}

	public function update($id)
	{
		$device = Device::find($id);
		$device->update($this->input);
		return redirect()->route('sales.device.show', $device->id);

	}
}
