<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
use App\Http\Controllers\Controller;

class PhoneAppController extends Controller
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
    public function create()
    {
        // 
    }

    public function manageNotifications($route_id) {
        $device = \DB::table('landlord_devices')
            ->where('routing_id', '=', $route_id)
            ->first();
        if(!$device) {
            DB::table('landlord_devices')->insert(
                ['user_id' => $this->user->id, 'routing_id' => $route_id, 'type' => '0', 'verified' => '0']
            );
            $device = \DB::table('landlord_devices')
            ->where('routing_id', '=', $route_id)
            ->first();
        }  
        return view('TenantSync::phoneverification', compact('device')); 
    }

    public function phoneverify($id) {
        if($this->input['notify']=="yes") {
            $verify=1;
        } else {
            $verify=2;
        }
        DB::table('landlord_devices')
            ->where('id', $id)
            ->update(['verified' => $verify]);
        return redirect('home');
    }

    public function isUser() {
        $returnValue="unsuccessful";
        if (Auth::attempt(['email' => $this->input['email'], 'password' => $this->input['password']])) {
            $returnValue="loggedin";
        }
        Auth::logout();
        return response()->json([$returnValue]);
    }

    public function receivingNotifications() {
        $returnValue="unsuccessful";
        if (Auth::attempt(['email' => $this->input['email'], 'password' => $this->input['password']])) {
            $device = \DB::table('landlord_devices')
                ->where('routing_id', '=', $this->input['routeid'])
                ->first();
            if(count($device)>0) {
                if($device->verified == 0 && $this->input['verify'] == "turnon") {
                    DB::table('landlord_devices')
                    ->where('id', $device->id)
                    ->update(['verified' => 1]);
                    $returnValue="notificationon";
                } else if($device->verified == 1 && $this->input['verify'] == "turnoff") {
                    DB::table('landlord_devices')
                    ->where('id', $device->id)
                    ->update(['verified' => 0]);
                    $returnValue="notificationoff";
                } else {
                    if($device->verified==0) {
                        $returnValue="notificationoff";
                    } else if($device->verified==1) {
                        $returnValue="notificationon";
                    }
                }
            } else {
                //Inserting device
                DB::table('landlord_devices')->insert(
                    ['user_id' => Auth::id(), 'routing_id' => $this->input['routeid'], 'type' => '0', 'verified' => '0']
                );
                $returnValue="notificationoff";
            }
        } else {
            $returnValue="loginfailed";
        }

        Auth::logout();
        return response()->json(['returnvalue' => $returnValue]);
        /*
        $device = \DB::table('landlord_devices')
            ->where('routing_id', '=', $route_id)
            ->first();
        if(!$device) {
            DB::table('landlord_devices')->insert(
                ['user_id' => $this->user->id, 'routing_id' => $route_id, 'type' => '0', 'verified' => '0']
            );
            $device = \DB::table('landlord_devices')
            ->where('routing_id', '=', $route_id)
            ->first();
        }  
        return view('TenantSync::phoneverification', compact('device')); 
        */
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
