<?php

namespace App\Console\Commands;

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
        $types = [
            'TenantSync\Models\Property' => 'property',
            'TenantSync\Models\Device' => 'device',
            'TenantSync\Models\User' => 'user'
        ];

        \Log::info('Running GenerateRecurringTransactions: \n');

        $transactions = RecurringTransaction::all()->filter(function($transaction) {
            if($transaction->schedule == 'day') {
                return true;
            }
            elseif($transaction->schedule == 'week' && date('w', time()) + 1 == $transaction->day) {
                return true;
            }
            elseif($transaction->schedule == 'month' && date('j', time()) == $transaction->day) {
                return false;
            }
        });

        foreach($transactions as $transaction) {
            Transaction::create([
                'user_id' => $transaction->user_id,
                'amount' => $transaction->amount,
                'description' => $transaction->description,
                'date' => date('Y-m-d', time()),
                'payable_type' => $types[$transaction->payable_type],
                'payable_id' => $transaction->payable_id,
            ]);
        }

        return 'Finished';
    }
}
