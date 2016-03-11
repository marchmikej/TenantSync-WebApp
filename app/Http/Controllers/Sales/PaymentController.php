<?php namespace App\Http\Controllers\Sales;

use App\Http\Requests;
use TenantSync\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Sales\BaseController;


class PaymentController extends SalesController {


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
		$landlord = User::find($this->input['user_id']);

		$paymentMethods = $landlord->getPaymentMethods();

		return view('TenantSync::sales.payment.create', compact('landlord', 'paymentMethods'));
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

	public function card()
	{
		// $result = $this->billing->charge($this->input['landlord_id'], $this->input, 'card', true);
		$user = User::find($id);

		if($user->charge($user->registration->amount_due)) {
			return redirect()->route('sales.landlord.show', [$this->input['landlord_id']])->withMessage('Payment method added.');
		}

		return redirect()->back()->withErrors([$result->error]);
	}

	public function show($id)
	{
		$landlord = User::find($id);

		return $landlord->getPaymentMethods();
	}

	public function update($id)
	{
		$landlord = User::find($id);
		
		if(!empty($this->input['id'])) {
			return response()->json($landlord->updatePaymentMethod($this->input));
		}

		return response()->json($landlord->addPaymentMethod($landlord, $this->input));
	}


}
