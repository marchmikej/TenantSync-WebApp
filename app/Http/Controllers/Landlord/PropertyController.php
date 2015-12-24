<?php namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Utilities\State;
use TenantSync\Models\Property;
use TenantSync\Models\Device;

class PropertyController extends Controller {

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
		$landlord = $this->user;
		foreach($landlord->properties as $property)
		{
			$roiGroup[] = $property->roi();
		}
		$roi = array_sum($roiGroup) / count($roiGroup);
		return view('TenantSync::landlord/properties/index', compact('landlord', 'roi'));
	}

	public function all()
	{
		if(isset($this->input['sortBy']))
		{
			if($this->input['sortBy'] == 'netIncome')
			{
				foreach($this->user->properties as $property)
				{
					$collection[$property->id] = $property->totalExpenses();
				}
				asort($collection, SORT_NUMERIC);
				$collection = array_slice($collection, 0, 3, true);
				$properties = array_keys($collection);
				$properties = Property::whereIn('id', $properties)->get();
				foreach($properties as $property)
				{
					$property->totalExpenses = $property->totalExpenses();
					$property->netIncome = $property->netIncome();
				}
				return response()->json($properties->toArray());die();
				return $properties->toArray();
			}
		}

		return $this->user->properties->load('devices')->each(function($property) 
			{	
				$property->roi();
			})
		->keyBy('id');
	}

	public function devices($id)
	{
		return Device::where(['property_id' => $id])->get();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$states = State::all();
		return view('TenantSync::landlord/properties/create', compact('states'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->input['user_id'] = $this->user->id;
		$property = Property::create($this->input);
		return redirect()->route('landlord.properties.show', [$property]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$property = Property::find($id);
		if(Gate::denies('owned-by-user', $property))
		{
			return abort(403, "Thats not yours!");
		}

		$states = State::all();
		return view('TenantSync::landlord/properties/show', compact('states', 'property'));
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
		$property = Property::find($id);
		if(Gate::denies('owned-by-user', $property))
		{
			return abort(403, "Thats not yours!");
		}

		$property->update(\Request::except('_token'));
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
