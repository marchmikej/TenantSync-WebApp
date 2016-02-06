<?php namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use TenantSync\Models\Device;
use TenantSync\Models\Property;
use TenantSync\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use TenantSync\Billing\RentPaymentGateway;
use TenantSync\Mutators\TransactionMutator;
use TenantSync\Models\RecurringTransaction;

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
		$landlord = $this->user;
		$netIncome = $this->user->netIncome('-1 month');
		return view('TenantSync::landlord.transactions.index', compact('landlord', 'netIncome'));
	}

	public function all()
	{	
		if(isset($this->input['with']))
		{
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
		$this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));
		$transaction = Transaction::create($this->input);
		if(isset($this->input['is_rent'])) {
			$device = Device::find($this->input['payable_id']);
			(new RentPaymentGateway($device))->processPayment($transaction->amount, $transaction);
		}
		// if($this->input['recurring'])
		// {
		// 	RecurringTransaction::create([
		// 		'transaction_id' => $transaction->id, 
		// 		'schedule' => $this->input['schedule'], 
		// 		'next_date' => date('Y-m-d', strtotime($transaction->date) + (60*60*24*$this->input['schedule']))
		// 	]);
		// }
		return $transaction;
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
		\DB::transaction(function() use ($id) {
			$transaction = Transaction::find($id);
			if(Gate::denies('owned-by-user', $transaction))
			{
				return abort(403, "That's not yours");
			}
			$this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));
			$transaction->update(['amount' => $this->input['amount'], 'description' => $this->input['description'], 'date' => $this->input['date'], 'payable_type' => $this->input['payable_type'], 'payable_id' => $this->input['payable_id']]);
			
			// if($transaction->rentPayments()) {
			// 	(new RentPaymentGateway)->
			// }
			// if($this->input['recurring'])
			// {
			// 	$schedule = (60*60*24*$this->input['schedule']);
			// 	$nextDate = strtotime($transaction->date) + $schedule;
			// 	while($nextDate < time())
			// 	{
			// 		$nextDate = $nextDate + $schedule;
			// 	}
			// 	$nextDate = date('Y-m-d', $nextDate);

			// 	if(! RecurringTransaction::where(['transaction_id' => $transaction->id])->exists())
			// 	{
			// 		RecurringTransaction::create([
			// 			'transaction_id' => $transaction->id, 
			// 			'schedule' => $this->input['schedule'], 
			// 			'next_date' => $nextDate
			// 		]);
			// 	}
			// 	RecurringTransaction::where(['transaction_id' => $transaction->id])->update([
			// 		'transaction_id' => $transaction->id, 
			// 		'schedule' => $this->input['schedule'], 
			// 		'next_date' => $nextDate
			// 	]);
				
			// }
			// if(!$this->input['recurring'] && $transaction->recurringTransaction)
			// {
			// 	RecurringTransaction::where([
			// 		'transaction_id' => $transaction->id, 
			// 	])
			// 	->delete();
			// }
		});
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$transaction = Transaction::find($id);
		if(Gate::denies('owned-by-user', $transaction))
		{
			return abort(403, "Thats not yours!");
		}

		if($transaction->recurringTransaction)
		{
			$transaction->recurringTransaction->delete();
		}

		return json_encode(Transaction::find($id)->delete());
	}

}
