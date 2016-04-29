<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use App\Http\Controllers\Manager\ManagerBaseController;

class ProfileController extends ManagerBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manager = $this->manager;

        return view('TenantSync::manager/profile/show', compact('manager'));
    }

    public function password()
    {
        if(! \Hash::check($this->input['current_password'], $this->user->password)) {
            return redirect()->back()->withErrors(["Current password doesn't match"]);
        }

        $this->validate($this->request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $this->user->password = \Hash::make($this->input['password']);

        $this->user->save();

        return redirect()->back();
    }

    public function email()
    {
        $this->validate($this->request, [
                'email' => 'required|email|unique:users,email',
            ]);
        
        $this->user->email = $this->input['email'];
        
        $this->user->save();
        
        return redirect()->back();
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
