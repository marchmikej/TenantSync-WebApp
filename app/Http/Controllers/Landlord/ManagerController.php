<?php

namespace App\Http\Controllers\Landlord;


use App\Http\Requests;
use TenantSync\Models\User;
use TenantSync\Models\Manager;
use App\Events\ManagerCreated;
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

    public function all()
    {
        $paginate = 15;
        $query = Manager::query(); 
        $query = $query->where(['landlord_id' => $this->user->id]);

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
        return $query->paginate($paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $landlord = $this->user;
        return view('TenantSync::landlord.managers.create', compact('landlord'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->input['role'] = 'manager';
        $this->input['landlord_id'] = $this->user->id;
        $userAccount = User::create($this->input);
        $userAccount->manager()->create($this->input);

        //fire off password reset email to the manager
        //Event::fire(new ManagerCreated($userAccount));

        return redirect()->route('landlord.managers.index');
    }

    public function addProperties()
    {
        $manager = Manager::find($this->input['manager_id']);
        $manager->properties()->attach($this->input['properties']);
        return $manager->with('properties')->get();

    }

    public function removeProperties()
    {
        $manager = Manager::find($this->input['manager_id']);
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

        $manager->user->delete();
        $manager->properties()->detach();
        $manager->delete();
        return $this->user->managers;
    }
}
