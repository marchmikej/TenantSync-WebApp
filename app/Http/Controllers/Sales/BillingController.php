<?php namespace App\Http\Controllers\Sales;

use App\Http\Requests;
use TenantSync\Models\Profile;
use App\Http\Controllers\Sales\BaseController;


class BillingController extends SalesController {

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
		$validator = \Validator::make($this->input, [
			'address' => 'required',
			'city' => 'required',
			'state' => 'required',
			'zip' => 'required'
		]);

		if($validator->fails()) {
			return redirect()->back()->withErrors($validator->errors());
		}
		
		$profile = Profile::find($id);
		
		$profile->update($this->input);
		
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
