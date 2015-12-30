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
        $returnValue="unsuccessful";
        if (Auth::attempt(['email' => $this->input['email'], 'password' => $this->input['password']])) {
            $devices = \DB::table('landlord_devices')
                ->where('user_id', '=', Auth::id())
                ->where('routing_id', '=', $this->input['routeId'])
                ->get();
            if(count($devices)==0) {
                DB::table('landlord_devices')->insert(
                    ['user_id' => $this->user->id, 'routing_id' => $this->input['routeId'], 'type' => $this->input['type']]
                );
            } 
            $returnValue="successful";
        }
        Auth::logout();
        return $returnValue;
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
