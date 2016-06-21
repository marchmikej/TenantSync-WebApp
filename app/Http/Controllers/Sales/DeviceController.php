<?php 

namespace App\Http\Controllers\Sales;

use Carbon\Carbon;
use TenantSync\Models\User;
use TenantSync\Models\Order;
use App\Http\Utilities\State;
use App\Http\Utilities\Token;
use TenantSync\Models\Device;
use TenantSync\Models\Property;
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
		$property = Property::find($id);

		$states = State::all();

		return view('TenantSync::sales.device.create', compact('property', 'states'));
	}

	public function store(CreateDeviceRequest $request, $id)
	{
		$property = Property::find($id);

		\DB::transaction(function() use ($id, $property) {
			$data = array_merge($this->input, [
				// 'token' => \Token::create(),
				'rent_due' => Carbon::parse('first day of next month'),
				'monthly_cost' => 10,
				'alarm_id' => 0,
				'status' => 'active',
			]);
			
			//$paymentMethodId = $data['payment_method_id'];

			$device = $property->addDevice($data);
		});

		return redirect()->route('sales.landlord.show', $property->landlord()->id);
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
