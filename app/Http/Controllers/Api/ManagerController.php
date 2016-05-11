<?php

namespace App\Http\Controllers\Api;

use Gate;
use TenantSync\Models\Manager;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $with = isset($this->input['with']) ? $this->input['with'] : [];

        $managers = $this->user->managers()->with($with)->get();

        return $managers;
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
    public function store()
    {
        //
    }

    public function addProperties()
    {
        $manager = Manager::find($this->input['manager_id']);

        if(Gate::denies('owned-by-user', $manager)) {
            return abort(403, "Thats not yours!");
        }

        $manager->properties()->attach($this->input['properties']);

        return $manager->with('properties')->get();
    }

    public function removeProperties()
    {
        $manager = Manager::find($this->input['manager_id']);

        if(Gate::denies('owned-by-user', $manager)) {
            return abort(403, "Thats not yours!");
        }
        $manager->properties()->detach($this->input['properties']);

        return $manager->with('properties')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // This needs to be reworked. Make sure no unique email conflicts happen.
        $manager = Manager::find($id);

        if(Gate::denies('owned-by-user', $manager)) {
            return abort(403, "Thats not yours!");
        }

        $manager->user->delete();

        $manager->properties()->detach();

        $manager->delete();

        return $this->user->managers;
    }
}
