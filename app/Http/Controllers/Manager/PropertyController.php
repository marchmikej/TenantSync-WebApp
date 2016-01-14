<?php

namespace App\Http\Controllers\Manager;

use Gate;
use App\Http\Utilities\State;
use App\Http\Requests;
use TenantSync\Models\Device;
use TenantSync\Models\Property;
use App\Http\Controllers\Controller;
use TenantSync\Mutators\PropertyMutator;

class PropertyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->manager = $this->user->manager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = $this->manager;
        foreach($manager->properties as $property)
        {
            $roiGroup[] = $property->roi();
        }
        $roi = array_sum($roiGroup) / count($roiGroup);
        return view('TenantSync::landlord/properties/index', compact('manager', 'roi'));
    }

    public function all()
    {
        $paginate = 15;
        $query = Property::whereIn('id', $this->manager->properties->keyBy('id')->keys()->toArray());

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

        //return Device::where(['user_id' => $this->user->id])->orderBy('rent_amount', 'desc')->with(['property', 'alarm'])->paginate(15);
        $result = $query->paginate($paginate);

        //$properties = $this->user->properties->load('devices')->keyBy('id');
        $properties = PropertyMutator::set('netIncome', $result);
        $properties = PropertyMutator::set('incomes', $result);
        $properties = PropertyMutator::set('expenses', $result);
        $properties = PropertyMutator::set('roi', $result);
        $result->data = $properties;
        return $result;
    }

    public function devices($id)
    {
        return Device::where(['property_id' => $id])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::find($id);
        if(Gate::denies('has-property', $property))
        {
            return abort(403, "Thats not yours!");
        }

        $states = State::all();
        return view('TenantSync::manager/properties/show', compact('states', 'property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $property = Property::find($id);
        if(Gate::denies('has-property', $property))
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
