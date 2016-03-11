<?php

namespace App\Http\Controllers\Manager;

use Gate;
use App\Http\Requests;
use TenantSync\Models\Device;
use TenantSync\Models\Message;
use App\Events\MessageCreatedByUser;
use App\Http\Controllers\Controller;

class MessageController extends Controller
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
        if(!empty($this->input['device_id'])) {
            return Device::find($this->input['device_id'])->messages;
        }

        if(!empty($this->input['limit'])) {
            return $this->manager->messages()->sortByDesc('created_at')->take($this->input['limit']);
        }

        return $this->manager->messages();
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
        $device = Device::find($this->input['device_id']);
        
        if(Gate::allows('has-device', $device))
        {
            Message::create([
                'user_id' => $this->manager->landlord->id,
                'device_id' => $this->input['device_id'],
                'body' => $this->input['message'],
                ]);
            \Event::fire(new MessageCreatedByUser($this->input['device_id'], $this->input['message']));
            return redirect()->back();
        }
        
        return abort(403, "Thats not yours!");
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
