<?php

namespace App\Http\Controllers\Manager;

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
        //
    }

    public function all()
    {
        $paginate = 15;
        $query = Property::where(['user_id' => $this->manager->landlord->id]);

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
