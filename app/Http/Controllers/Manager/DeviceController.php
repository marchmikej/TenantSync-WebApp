<?php namespace App\Http\Controllers\Manager;

use Gate;
use App\Http\Requests;
use TenantSync\Models\Device;
use TenantSync\Models\Manager;
use TenantSync\Mutators\DeviceMutator;
use App\Http\Controllers\Manager\ManagerBaseController;


class DeviceController extends ManagerBaseController {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$devices = $this->manager->devices()->toArray();

		$manager = $this->manager;

		return view('TenantSync::manager/device/index', compact('devices', 'manager'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$device = Device::find($id);

		$device = DeviceMutator::set('balance', $device);

		if(Gate::denies('has-device', $device)) {
			return abort(403, "Thats not yours!");
		}

	    $device->markMessagesAsRead();

		\JavaScript::put([
	        'device' => $device,
	        'deviceMessages' => $device->messages,
	    ]);

		return view('TenantSync::manager/device/show', compact('device'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$device = Device::find($id);

		if(Gate::denies('has-device', $device)) {
			return abort(403, "Thats not yours!");
		}

		$device->update(\Request::except('_token'));
		
		return redirect()->back();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
