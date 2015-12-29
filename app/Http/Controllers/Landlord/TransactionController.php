<?php namespace App\Http\Controllers\Landlord;

use Gate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use TenantSync\Models\Transaction;
use TenantSync\Models\RecurringTransaction;
use TenantSync\Models\Property;

class TransactionController extends Controller {

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
		$landlord = $this->user;
		foreach($landlord->properties as $property)
		{
			$netIncomes[] = $property->netIncome();
		}
		$netIncome = array_sum($netIncomes);
		return view('TenantSync::landlord.transactions.index', compact('landlord', 'netIncome'));
	}

	public function all()
	{
		$transactions = Transaction::where(['user_id' => $this->user->id])->get()->load('payable')->keyBy('id');
		foreach($transactions as $transaction)
		{
			if($transaction->payable_type == 'TenantSync\\Models\\Device')
			{
				$transaction->property = Property::find($transaction->payable->property_id);
			}
		}

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
	public function store(Requests\TransactionCreatedRequest $request)
	{
		$this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));
		$transaction = Transaction::create($this->input);
		if($this->input['recurring'])
		{
			RecurringTransaction::create([
				'transaction_id' => $transaction->id, 
				'schedule' => $this->input['schedule'], 
				'next_date' => date('Y-m-d', strtotime($transaction->date) + (60*60*24*$this->input['schedule']))
			]);
		}
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
	public function update($id)
	{
		$transaction = Transaction::find($id);
		if(Gate::denies('owned-by-user', $transaction))
		{
			return abort(403, "That's not yours");
		}
		$this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));
		$transaction->update(['amount' => $this->input['amount'], 'description' => $this->input['description'], 'date' => $this->input['date'], 'payable_type' => $this->input['payable_type'], 'payable_id' => $this->input['payable_id']]);
		
		if($this->input['recurring'])
		{
			RecurringTransaction::create([
				'transaction_id' => $transaction->id, 
				'schedule' => $this->input['schedule'], 
				'next_date' => date('Y-m-d', strtotime($transaction->date) + (60*60*24*$this->input['schedule']))
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
