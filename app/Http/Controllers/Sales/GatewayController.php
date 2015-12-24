<?php namespace App\Http\Controllers\Sales;

use App\Http\Requests;
use Illuminate\Http\Request;
use TenantSync\Models\User;
use App\Http\Controllers\Sales\BaseController;
use TenantSync\Landlord\LandlordGateway;


class GatewayController extends SalesController {


	public function __construct(LandlordGateway $landlordGateway)
	{
		$this->landlordGateway = $landlordGateway;
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
		$landlord = User::find($id);
		$landlord->gateway->pin = $this->input['pin'];
		$landlord->gateway->key = $this->input['key'];
		$landlord->push();
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
