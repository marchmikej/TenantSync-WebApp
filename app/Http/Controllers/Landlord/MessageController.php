<?php namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use Illuminate\Http\Request;
use TenantSync\Models\Message;
use TenantSync\Models\Device;
use TenantSync\Models\Conversation; 
use App\Http\Controllers\Controller;
use App\Events\MessageCreatedByUser;
use App\Events\DeviceMadeUpdate;

class MessageController extends Controller {

	public function __construct(Request $request)
	{
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$messages =  $this->user->messages;

		return view('TenantSync::landlord/messages/index', compact('messages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\MessageCreatedRequest $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
