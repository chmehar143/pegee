<?php

namespace App\Console\Commands;

use App\Order;
use Illuminate\Console\Command;
use App\OrderTransactionDetail;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class FetchTransactionAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:transactionAmount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will fetch all transactions amount from authorize.net and populate the data in the order transaction details table';

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
        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $this->merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));
        $orderTransactionDetails = OrderTransactionDetail::where('transaction_amount', '<=', 0)->get();
        echo $orderTransactionDetails->count() . " RECORDS TO PROCESS \r\n";
        if($orderTransactionDetails->count() > 0){
            foreach($orderTransactionDetails as $transactionDetail){
                echo "PROCESSING WITH TRANSACTION ID: " . $transactionDetail->transaction_id . "\r\n";
                $request = new AnetAPI\GetTransactionDetailsRequest();
                $request->setMerchantAuthentication($this->merchantAuthentication);
                $request->setTransId($transactionDetail->transaction_id);
                $controller = new AnetController\GetTransactionDetailsController($request);
                if (env('APP_ENV') == "production") {
                    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                } else {
                    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                }
                if (($response != null) && ($response->getMessages()->getResultCode() == env('ANET_RESPONSE_OK'))) {
                    if ($response->getTransaction()->getTransactionStatus() == "settledSuccessfully") {
                        $transactionDetail->transaction_amount = $response->getTransaction()->getSettleAmount();
                    }else{
                        $transactionDetail->transaction_amount = $response->getTransaction()->getAuthAmount();
                    }
                    echo "TRANSACTION STATUS: " . $response->getTransaction()->getTransactionStatus() . "\r\n";
                    echo "AUTH AMOUNT: " . $response->getTransaction()->getAuthAmount() . "\r\n";
                    echo "SETTLE AMOUNT: " . $response->getTransaction()->getSettleAmount() . "\r\n";
                }else{
                    echo "ERROR :  Invalid response \r\n";
                    $errorMessages = $response->getMessages()->getMessage();
                    echo "ERROR CODE: " . $errorMessages[0]->getCode() . "\r\n";
                    echo "ERROR Description: " . $errorMessages[0]->getText() . "\r\n";
                    $transactionDetail->error_code = $errorMessages[0]->getCode();
                    $transactionDetail->error_description = $errorMessages[0]->getText();
                }
                $transactionDetail->save();
                echo "END PROCESSING WITH TRANSACTION ID: " . $transactionDetail->transaction_id . "\r\n";
                echo "------------------------------------------------------------------------------\r\n";
            }
        }

    }
}
