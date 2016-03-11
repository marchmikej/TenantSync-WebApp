<?php namespace App\Http\Controllers\Sales;

use TenantSync\Models\User;
use TenantSync\Models\Order;
use TenantSync\Models\Device;
use TenantSync\Models\Property;
use App\Http\Utilities\State;
use App\Http\Requests\CreateDeviceRequest;
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

	public function create($id)
	{
		$landlord = User::find($id);

		$states = State::all();

		return view('TenantSync::sales.device.create', compact('landlord', 'states'));
	}

	public function store(CreateDeviceRequest $request, $id)
	{
		\DB::transaction(function() use ($id) {
			$this->input['token'] = \Token::create();

			$this->input['rent_due'] = \Carbon\Carbon::parse('first day of next month');

			$this->input['monthly_cost'] = 10;

			$this->input['alarm_id'] = 0;

			$this->input['status'] = 'active';

			$this->input['user_id'] = $id;

			$device = Device::create($this->input);

			$this->input['device_id'] = $device->id;

			$order = Order::create($this->input);

			//$device->owner->addDevice($device);
			
			//return view('TenantSync::sales.device.show', compact('device'));
		});
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

		//return view('TenantSync::sales.device.edit', compact('device'));
		return view('TenantSync::sales.device.show', compact('device'));
	}

	public function update($id)
	{
		$device = Device::find($id);
		
		$device->update($this->input);
		
		return redirect()->route('sales.device.show', $device->id);

	}
}
