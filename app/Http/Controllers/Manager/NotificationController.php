<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests;
use Illuminate\Http\Request;
use TenantSync\Models\CellCarrier;
use TenantSync\Models\Notification;
use App\Http\Controllers\Manager\ManagerBaseController;

class NotificationController extends ManagerBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::all();

        $userNotifications = $this->manager->notifications;

        $cellCarriers = CellCarrier::all();

        \JavaScript::put([
            'allNotifications' => $notifications->toJson(),
            'userNotifications' => $userNotifications->toJson(),
            'notifyByEmail' => $this->manager->email_notifications,
            'notifyByText' => $this->manager->text_notifications,
            'cellCarrier' => $this->manager->cell_carrier_id,
            'cellCarriers' => $cellCarriers,
        ]);

        return view('TenantSync::manager.notifications', compact('notifications'));
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
    public function update()
    {
        $notificationIds = $this->input['notification_ids'];

        return $this->manager->updateNotifications($notificationIds);
    }

    public function updateMethods()
    {
        $email =  $this->input['email'];

        $text =  $this->input['text'];

        return $this->manager->updateNotificationMethods($email, $text);
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
