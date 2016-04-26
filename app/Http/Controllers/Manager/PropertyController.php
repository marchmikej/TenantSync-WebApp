<?php

namespace App\Http\Controllers\Manager;

use Gate;
use App\Http\Requests;
use App\Http\Utilities\State;
use TenantSync\Models\Device;
use TenantSync\Models\Property;
use TenantSync\Mutators\PropertyMutator;
use App\Http\Controllers\Manager\ManagerBaseController;

class PropertyController extends ManagerBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = $this->manager;

        return view('TenantSync::landlord/properties/index', compact('manager'));
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

        if(Gate::denies('has-property', $property)) {
            return abort(403, "Thats not yours!");
        }

        $states = State::all();

        return view('TenantSync::manager.properties.show', compact('states', 'property'));
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

        if(Gate::denies('has-property', $property)) {
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
