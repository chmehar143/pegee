<?php

namespace App\Console\Commands;

use App\AuthorizeTransactionLog;
use Illuminate\Console\Command;

class RetryFailedTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RetryFailedTransactions:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry authroized.net failed transactions';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "******************* RETRY FAILDED TRANSACTION CRON STARTED AT " . date("Y-m-d H:i:s") . " *******************\r\n";
        $transactions = AuthorizeTransactionLog::getTransactionsToRetry();

        $client = new \GuzzleHttp\Client();
        foreach($transactions as $transaction){
            $transactionId = $transaction->transaction_id;
            $client->request('POST', env('APP_URL') . '/authorize/payment-status', [ 'json' => ['payload' => ['id' => $transactionId]]]);
        }
        echo "******************* RETRY FAILDED TRANSACTION CRON FINISHED AT " . date("Y-m-d H:i:s") . " *******************\r\n";

    }
}
