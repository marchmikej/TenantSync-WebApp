<?php

namespace App\Http\Controllers\Api;

use TenantSync\Models\Transaction;
use TenantSync\Mutators\TransactionMutator;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->transactionMutator = new TransactionMutator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $with = [];
        if(isset($this->input['with']))
        {
            $with = $this->input['with'];
        }

        $transactions = Transaction::getTransactionsForUser($this->user, $with);
        $transactions = $this->transactionMutator->set('address', $transactions);
        $transactions = $this->transactionMutator->set('payable', $transactions);
        return $transactions;
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
