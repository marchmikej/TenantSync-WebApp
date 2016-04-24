<?php namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use TenantSync\Models\Device;
use TenantSync\Mutators\DeviceMutator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AuthorizesUsers;

class DeviceController extends Controller {

	public function __construct()
	{

		parent::__construct();
	}

	/**
	 * Display a listing of the resource. 
	 *
	 * @return Response
	 */
	public function index()
	{
		$devices = Device::where(['user_id' => $this->user->id])->get();

		return view('TenantSync::landlord/device/index', compact('devices'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// $propertyId = isset($this->input['propertyId']) ? $this->input['propertyId'] : '';
		// return view('Tenantsync::landlord/device/create', compact('propertyId'));
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

		if(Gate::denies('owned-by-user', $device)) {
			return abort(403, "Thats not yours!");
		}

	    $device->markMessagesAsRead();

		\JavaScript::put([
	        'device' => $device,
	        'deviceMessages' => $device->messages,
	    ]);
	    
		return view('TenantSync::landlord/device/show', compact('device'));
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

		if(Gate::denies('owned-by-user', $device)) {
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
