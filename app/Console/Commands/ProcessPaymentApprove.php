<?php

namespace App\Console\Commands;

use App\EmailTemplate;
use Illuminate\Console\Command;
use App\OrderTransactionDetail;
use App\Mail\SingleProductOrderUpdate;
use Illuminate\Support\Facades\Log;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class ProcessPaymentApprove extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ProcessPaymentApprove:processpayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change transaction payment status to paid in order transaction detail table';

    /**
     * @var $merchantAuthentication
     */
    protected $merchantAuthentication;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $this->merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        echo "******************* PAYMENT CRON STARTED AT " . date("Y-m-d H:i:s") . " *******************\r\n";
        $send_email = false;
        $paymentStatus = array(4, 5);
        $currentDate = date('Y-m-d H:i:00', strtotime('-12 hours', strtotime(date('Y-m-d H:i:00'))));
        $orderTransactionDetails = OrderTransactionDetail::whereIn('payment_status', $paymentStatus)
            ->where('date_time', '<=', $currentDate)
            ->limit(10)
            ->get();
        echo $currentDate . " Date \r\n";
        echo count($orderTransactionDetails) . " TO PROCESS \r\n";
        foreach ($orderTransactionDetails as $transactionDetail) {
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
                echo "TRANSACTION ID: " . $transactionDetail->transaction_id . "\r\n";
                echo "CURRENT TRANSACTION STATUS: " . $transactionDetail->payment_status . "\r\n";
                echo "GATEWAY TRANSACTION STATUS: " . $response->getTransaction()->getTransactionStatus() . "\r\n";
                if ($response->getTransaction()->getTransactionStatus() == "settledSuccessfully") {
                    $transactionDetail->payment_status = 1;
                    $transactionDetail->transaction_amount = $response->getTransaction()->getSettleAmount();
                    $send_email = true;
                } else if ($response->getTransaction()->getTransactionStatus() == "capturedPendingSettlement") {
                    $transactionDetail->payment_status = 5;
                    $transactionDetail->transaction_amount = $response->getTransaction()->getAuthAmount();
                } else if ($response->getTransaction()->getTransactionStatus() == "expired") {
                    $transactionDetail->payment_status = 2;
                }
            } else {
                echo "ERROR :  Invalid response \r\n";
                $errorMessages = $response->getMessages()->getMessage();
                echo "ERROR CODE: " . $errorMessages[0]->getCode() . "\r\n";
                echo "ERROR Description: " . $errorMessages[0]->getText() . "\r\n";
                $transactionDetail->error_code = $errorMessages[0]->getCode();
                $transactionDetail->error_description = $errorMessages[0]->getText();
            }
            $transactionDetail->save();
            if ($send_email) {
                $admin_payment_approve_email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_PAYMENT_APPROVE_EMAIL)
                    ->where('is_active', 1)
                    ->first();
                if ($admin_payment_approve_email_template) {
                    try{
                        \Mail::to(env('PAYMENT_APPROVED_EMAIL'))->send(new SingleProductOrderUpdate($transactionDetail->getOrderDetail, $admin_payment_approve_email_template, $transactionDetail));
                    } catch (\Exception $e) {
                        Log::warning($e->getMessage());
                    }
                }
            }
        }
        echo "******************* PAYMENT CRON COMPLETED AT " . date("Y-m-d H:i:s") . " *******************\r\n";
    }

}
