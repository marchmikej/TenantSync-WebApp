<?php namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use TenantSync\Models\Device;
use TenantSync\Models\Property;
use TenantSync\Models\Transaction;
use App\Http\Controllers\Controller;
use TenantSync\Billing\RentPaymentGateway;
use TenantSync\Models\RecurringTransaction;
use TenantSync\Mutators\TransactionMutator;
use App\Http\Requests\CreateTransactionRequest;

class TransactionController extends Controller {

	public function __construct(TransactionMutator $transactionMutator)
	{
		parent::__construct();
		$this->transactionMutator = $transactionMutator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$manager = $this->user->manager;
		$netIncome = $this->user->netIncome('-1 month');
		return view('TenantSync::manager.transactions.index', compact('manager', 'netIncome'));
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
	public function store(CreateTransactionRequest $request)
	{
		// $this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));

		// $transaction = Transaction::create($this->input);

		// if(isset($this->input['is_rent'])) {
		// 	$device = Device::find($this->input['payable_id']);

		// 	(new RentPaymentGateway($device))->processPayment($transaction->amount, $transaction);
		// }

		// return $transaction;
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
	public function update(CreateTransactionRequest $request, $id)
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
