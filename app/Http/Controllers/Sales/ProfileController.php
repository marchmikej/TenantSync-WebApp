<?php namespace App\Http\Controllers\Sales;

use App\Http\Requests;
use Illuminate\Http\Request;
use TenantSync\Models\Profile;
use App\Http\Controllers\Sales\BaseController;

class ProfileController extends SalesController {


	public function __construct()
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
		//
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
	public function store()
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
		$profile = Profile::find($id);

		return view('TenantSync::sales/landlord/profile/edit', comapact('$profile'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$profile = Profile::find($id);

		$validator = \Validator::make($this->input, [
			'email' => 'required|email|unique:users,email,'.$profile->owner->id,
			'phone' => 'required',
		]);

		if($validator->fails())
		{
			return redirect()->back()->withErrors($validator->errors());
		}

		$profile->update(['company' => $this->input['company'], 'phone' => $this->input['phone']]);

		$profile->owner->email = $this->input['email'];

		$profile->push();

		//if not return error
		return redirect()->back();
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
