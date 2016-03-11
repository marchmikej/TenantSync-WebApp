<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TenantSync\Models\RecurringTransaction;
use TenantSync\Models\Transaction;

class GenerateRecurringTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GenerateRecurringTransactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates recurring transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Running GenerateRecurringTransactions: ');

        $transactions = RecurringTransaction::all();

        foreach($transactions as $transaction) {
            if($this->transactionHasNotBeenRun($transaction)) {
                $this->createNewTransaction($transaction);
            }
        }
    }

    public function transactionHasNotBeenRun($transaction)
    {
        $lastCreationDate = $transaction->last_ran;

        $expectedlastCreation = date('Y-m-d', time() - strtotime('1 ' . $transaction->schedule, 0));

        return $lastCreationDate < $expectedlastCreation;
    }

    public function createNewTransaction($transaction)
    {
        $types = [
            'TenantSync\Models\Property' => 'property',
            'TenantSync\Models\Device' => 'device',
            'TenantSync\Models\User' => 'user'
        ];

        $date = date('Y-m-d', strtotime($transaction->last_ran) + strtotime('1 ' . $transaction->schedule, 0));

        Transaction::create([
            'user_id' => $transaction->user_id,
            'amount' => $transaction->amount,
            'description' => $transaction->description,
            'date' => $date,
            'payable_type' => $types[$transaction->payable_type],
            'payable_id' => $transaction->payable_id,
        ]);

        $transaction->last_ran = $date;

        $transaction->save();
    }
}
