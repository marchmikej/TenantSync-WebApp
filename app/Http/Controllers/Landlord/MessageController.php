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
use App\Http\Controllers\Traits\AuthorizesUsers;


class MessageController extends Controller {

	use AuthorizesUsers;

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

	public function all()
	{
		if(!empty($this->input['device_id']))
		{
			return Message::where('device_id', '=', $this->input['device_id'])->orderBy('created_at')->get()->keyBy('id');
		}
		else
		{
			// return Message::where('device_id', '=', $this->user->devices->fetch('id')->toArray())->take(10)->get()->keyBy('id');
			return Message::where('user_id', '=', $this->user->id)->with('device')->take(5)->orderBy('created_at')->get()->keyBy('id');
		}
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
		$device = Device::find($this->input['device_id']);
		
		if(Gate::allows('owned-by-user', $device))
		{
			Message::create([
				'user_id' => $this->user->id,
				'device_id' => $this->input['device_id'],
				'body' => $this->input['message'],
				'hidden' => 0,
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
