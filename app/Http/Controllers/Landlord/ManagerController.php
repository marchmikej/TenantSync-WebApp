<?php

namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use TenantSync\Models\User;
use TenantSync\Models\Manager;
use App\Events\ManagerCreated;
use App\Http\Requests\CreateManagerRequest;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('TenantSync::landlord.managers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manager = $this->user->manager;

        return view('TenantSync::landlord.managers.create', compact('manager'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateManagerRequest $request)
    {
        $this->input['role'] = 'manager';

        $this->input['landlord_id'] = $this->user->id;

        $user = User::create($this->input);

        $user->manager()->create($this->input);

        //fire off password reset email to the manager
        //Event::fire(new ManagerCreated($userAccount));

        return redirect()->route('landlord.managers.index');
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
    public function update(Request $request, $id)
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
