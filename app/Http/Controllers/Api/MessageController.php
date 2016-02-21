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
        
        // $this->set = isset($this->input['set']) ? $this->input['set'] : [];
        
        $this->limit = isset($this->input['limit']) ? $this->input['limit'] : null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::getMessagesForUser($this->user, ['with' => $this->with, 'limit' => $this->limit]);

        // $messages = MessageMutator::set($this->set, $messages);

        return $messages;
    }

    public function forDevice($id)
    {
        $device = Device::find($id);

        if(Gate::denies('has-device', $device)) {
            abort(403, 'That\'s not yours!');
        }

        return $device->messages;
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
        $deviceId = $this->input['device_id'];

        $deviceIds = is_array($deviceId) ? $deviceId : array($deviceId);

        $devices = Device::whereIn('id', $deviceIds)->get();

        $messages = [];

        foreach ($devices as $device) {
            if(! Gate::allows('has-device', $device))
            {
                continue;
            } 
            

            $messages[] = Message::create(['user_id' => $this->user->id,'device_id' => $device->id,'body' => $this->input['body'],]);

            \Event::push('MessageCreatedByUser', $device->id, $this->input['body']);
        }

        return $messages;
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
        $message = Message::find($id);

        if(Gate::denies('has-device', $message->device)) {
            abort(403, 'That\'s not yours');
        }

        $message->delete();

        return 'success';
    }
}
