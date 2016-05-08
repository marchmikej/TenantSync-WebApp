<?php namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use TenantSync\Models\Device;
use App\Http\Utilities\State;
use TenantSync\Models\Property;
use TenantSync\Mutators\PropertyMutator;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePropertyRequest;

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
		$manager = $this->user->manager;		

		return view('TenantSync::manager/properties/index', compact('manager'));
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
	public function store(CreatePropertyRequest $request)
	{
		// $this->input['user_id'] = $this->user->id;

		// $property = Property::create($this->input);

		$property = $this->user->properties()->create($this->input);

		$this->user->manager->properties()->attach($property->id);

		return redirect()->route('manager.properties.show', [$property]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$landlord = $this->user;

		// $landlord->charge(500, [
		// 	'account_holder' => 'mitchtest',  
		// 	'card' => [
		// 		'card_number' => '4000100211112222', 
	 // 			'expiration' => '0919', 
	 // 			'cvv2' => '999',
		// 	 ] ,
		// 	'description' => "mitch's test charge with new billable trait", 
		// 	// 'address' => '5042 parker rd', 
		// 	// 'zip' => '14075'
		// ]);

		$property = Property::find($id);

		if(Gate::denies('owned-by-user', $property)){
			return abort(403, "Thats not yours!");
		}

		$states = State::all();

		return view('TenantSync::manager/properties/show', compact('states', 'property'));
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
	public function update(CreatePropertyRequest $request, $id)
	{
		$property = Property::find($id);

		if(Gate::denies('owned-by-user', $property)) {
			return abort(403, "Thats not yours!");
		}

		$property->update($this->input);

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
