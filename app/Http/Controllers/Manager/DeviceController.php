<?php namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use TenantSync\Models\Device;
use TenantSync\Models\Manager;
use App\Http\Controllers\Controller;


class DeviceController extends Controller {

	public function __construct()
	{
		parent::__construct();
		$this->manager = $this->user->manager;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$properties = $this->manager->devices;
		return view('TenantSync::manager/device/index', compact('properties'));
	}

	public function all()
	{
		return $this->manager->devices;
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
		//
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
