<?php

namespace App\Http\Controllers\Landlord;


use App\Http\Requests;
use TenantSync\Models\Manager;
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
        //
    }
}
