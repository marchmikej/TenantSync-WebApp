<?php

namespace App\Http\Controllers\Sales;

use App\Http\Requests;
use TenantSync\Models\User;
use Illuminate\Http\Request;
use App\Http\Utilities\State;
use TenantSync\Models\Property;
use App\Http\Controllers\Controller;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $landlord = User::find($id);

        $states = State::all();

        return view('TenantSync::sales.properties.create', compact('landlord', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $landlord = User::find($id);

        $property = $landlord->properties()->create($this->input);

        $states = State::all();

        return redirect('/sales/properties/' . $property->id . '/device/create');
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

        $states = State::all();

        return view('TenantSync::sales.properties.show', compact('property', 'states'));
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

        // if(Gate::denies('has-property', $property)) {
        //     return abort(403, "Thats not yours!");
        // }

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
