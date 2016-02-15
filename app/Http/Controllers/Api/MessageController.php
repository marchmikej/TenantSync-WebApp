<?php

namespace App\Http\Controllers\Api;

use App\Events\Event;
use App\Events\MessageCreatedByUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePropertyRequest;
use Gate;
use TenantSync\Models\Device;
use TenantSync\Models\Message;

class MessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->with = isset($this->input['with']) ? $this->input['with'] : [];
        
        $this->set = isset($this->input['set']) ? $this->input['set'] : [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::getMessagesForUser($this->user, $this->with);

        $messages = Message::set($this->set, $messages);

        return $messages;
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
        $deviceIds = $this->input['device_ids'];

        $devices = Device::whereIn('id', $deviceIds)->get();

        foreach ($devices as $device) {
            if(! Gate::allows('has-device', $device))
            {
                continue;
            } 

            Message::create(['user_id' => $this->user->id,'device_id' => $device->id,'body' => $this->input['message'],]);

            \Event::push('MessageCreatedByUser', $device->id, $this->input['message']);
        }

        return 'success';
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
