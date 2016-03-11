<?php namespace App\Http\Controllers\Manager;

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

		$this->manager = $this->user->manager;

		$this->transactionMutator = $transactionMutator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$landlord = $this->manager->landlord;

		$manager = $this->manager;

		foreach($manager->properties as $property) {
			$netIncomes[] = $property->netIncome('-1 month');
		}

		$netIncome = array_sum($netIncomes);

		return view('TenantSync::manager.transactions.index', compact('manager', 'landlord', 'netIncome'));
	}

	public function all()
	{	
		$transactions = (new Transaction)->getTransactionsForUser($this->user);

		if(isset($this->input['with'])) {
			$with = $this->input['with'];
		}

		$transactions = $this->transactionMutator->set('address', $transactions);

		return $transactions;
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
		\DB::transaction(function() {
			$this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));

			$transaction = Transaction::create($this->input);

			return $transaction;
		});
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
