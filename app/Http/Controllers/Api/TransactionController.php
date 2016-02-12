<?php

namespace App\Http\Controllers\Api;

use Gate;
use TenantSync\Models\Transaction;
use App\Http\Controllers\Controller;
use TenantSync\Mutators\TransactionMutator;
use App\Http\Requests\CreateTransactionRequest;

class TransactionController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->with = isset($this->input['with']) ? $this->input['with'] : [];

        $this->set = isset($this->input['set']) ? $this->input['set'] : [];
        
        $this->fromDate = isset($this->input['from']) ? $this->input['from'] : 'January 1 2000';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::getTransactionsForUser($this->user, $this->with, $this->fromDate);

        $transactions = TransactionMutator::set($this->set, $transactions);

        return $transactions->keyBy('id');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));
        $transaction = Transaction::create($this->input);

        return $transaction;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTransactionRequest $request, $id)
    {
        \DB::transaction(function() use ($id) {
            $transaction = Transaction::find($id);
            if(Gate::denies('has-transaction', $transaction))
            {
                return abort(403, "That's not yours");
            }
            $this->input['date'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input['date'])));
            $transaction->update([
                'amount' => $this->input['amount'], 
                'description' => $this->input['description'], 
                'date' => $this->input['date'], 
                'payable_type' => $this->input['payable_type'], 
                'payable_id' => $this->input['payable_id']
            ]);
            return $transaction;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
