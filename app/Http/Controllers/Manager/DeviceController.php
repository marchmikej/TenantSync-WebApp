<?php namespace App\Http\Controllers\Manager;

use Gate;
use TenantSync\Api\ApiQuery;
use App\Http\Requests;
use TenantSync\Models\Device;
use TenantSync\Models\Manager;
use App\Http\Controllers\Controller;


class DeviceController extends Controller {

	public function __construct()
	{
		parent::__construct();
		$this->manager = $this->user->manager;
		$this->apiQuery = new ApiQuery('Device');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$devices = $this->manager->devices();
		$manager = $this->manager;
		return view('TenantSync::manager/device/index', compact('devices', 'manager'));
	}

	public function all()
	{
		$list = $this->apiQuery->whereIn('property_id', $this->manager->properties->keyBy('id')->keys()->toArray())->select('devices.*');
		$list->with($with);

		if(isset($this->input['sort']) && ! empty($this->input['sort']))
		{
			$sort = $this->input['sort'];
			$order = isset($this->input['asc']) && $this->input['asc'] != 1 ? 'desc' : 'asc';
			$query = $query->orderBy($sort, $order);
		}
		
		if(isset($this->input['paginate']))
		{
			$paginate = $this->input['paginate'];
		}	
		
		if(isset($this->input['with']))
		{
			$with = $this->input['with'];
			$query = $query->with($with);
		}

		return $query->paginate($paginate);
		//return \DB::table('devices')->whereIn('property_id', $this->properties->keyBy('id')->keys()->toArray())->select('devices.*')->paginate()

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
		if(Gate::denies('has-device', $device))
		{
			return abort(403, "Thats not yours!");
		}

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

		if(Gate::denies('has-device', $device))
		{
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
