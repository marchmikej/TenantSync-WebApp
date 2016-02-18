<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use Gate;
use TenantSync\Models\RecurringTransaction;
use TenantSync\Models\Transaction;
use TenantSync\Mutators\TransactionMutator;

class RecurringTransactionController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->with = isset($this->input['with']) ? $this->input['with'] : [];

        $this->set = isset($this->input['set']) ? $this->input['set'] : [];
        
        // $this->fromDate = isset($this->input['from']) ? $this->input['from'] : 'January 1 2000';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = RecurringTransaction::getTransactionsForUser($this->user, $this->with);

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
    public function store() //CreateRecurringTransactionRequest $request,
    {
        \DB::transaction(function() use ($id) {
            
        });
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
    public function update($id) //CreateRecurringTransactionRequest $request,
    {
        \DB::transaction(function() use ($id) {
            $transaction = RecurringTransaction::find($id);

            if(Gate::denies('has-transaction', $transaction)) {
                abort(403, 'Thats not yours!');
            }

            $transaction->update($this->input);
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
        $transaction = RecurringTransaction::find($id);

        if(Gate::denies('has-recurring', $transaction))
        {
            return abort(403, "Thats not yours!");
        }

        return json_encode(RecurringTransaction::find($id)->delete());
    }
}
