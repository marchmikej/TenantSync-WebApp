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
		foreach($manager->properties as $property)
		{
			$netIncomes[] = $property->netIncome('-1 month');
		}
		$netIncome = array_sum($netIncomes);
		return view('TenantSync::manager.transactions.index', compact('manager', 'landlord', 'netIncome'));
	}

	public function all()
	{
		$transactions = array_map(function($transaction) {
			return $transaction->id;
		}, $this->manager->transactions());

		$paginate = 15;
		$query = Transaction::whereIn('id', $transactions);

		if(isset($this->input['sort']) && ! empty($this->input['sort']))
		{
			$sort = $this->input['sort'];
			$order = isset($this->input['asc']) && $this->input['asc'] != 1 ? 'desc' : 'asc';
			$query = $query->orderBy($sort, $order);
		}
		
		if(isset($this->input['paginate']) && !empty($this->input['paginate']))
		{
			$paginate = $this->input['paginate'];
		}	
		
		if(isset($this->input['with']))
		{
			$with = $this->input['with'];
			$query = $query->with($with);
		}

		if(isset($this->input['dates']['from']) && !empty($this->input['dates']['from'])) {
			$from = $this->input['dates']['from'];
			$query->where('date', '>', date('Y-m-d', strtotime($from)));

			// if(isset($this->input['date']['to'])) {
			// 	$to = $this->input['dates']['to'];
			// 	$query->where('date', '<', date('Y-m-d', strtotime($to)));
			// }
		}

		$paginated =  $query->paginate($paginate);
		$transactions =  $paginated->load('payable');
		$this->transactionMutator->set('address', $transactions);
		$paginated->data = $transactions;
		return $paginated;
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
			if(isset($this->input['is_rent'])) {
				$device = Device::find($this->input['payable_id']);
				(new RentPaymentGateway($device))->processPayment($transaction->amount, $transaction);
			}
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
		$transaction = Transaction::find($id);
		if(Gate::denies('has-transaction', $transaction))
		{
			return abort(403, "That's not yours");
		}
		$this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));
		$transaction->update(['amount' => $this->input['amount'], 'description' => $this->input['description'], 'date' => $this->input['date'], 'payable_type' => $this->input['payable_type'], 'payable_id' => $this->input['payable_id']]);
		
		if($this->input['recurring'])
		{
			$schedule = (60*60*24*$this->input['schedule']);
			$nextDate = strtotime($transaction->date) + $schedule;
			while($nextDate < time())
			{
				$nextDate = $nextDate + $schedule;
			}
			$nextDate = date('Y-m-d', $nextDate);

			if(! RecurringTransaction::where(['transaction_id' => $transaction->id])->exists())
			{
				RecurringTransaction::create([
					'transaction_id' => $transaction->id, 
					'schedule' => $this->input['schedule'], 
					'next_date' => $nextDate
				]);
			}
			RecurringTransaction::where(['transaction_id' => $transaction->id])->update([
				'transaction_id' => $transaction->id, 
				'schedule' => $this->input['schedule'], 
				'next_date' => $nextDate
			]);
			
		}
		if(!$this->input['recurring'] && $transaction->recurringTransaction)
		{
			RecurringTransaction::where([
				'transaction_id' => $transaction->id, 
			])
			->delete();
		}
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
		if(Gate::denies('has-transaction', $transaction))
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
