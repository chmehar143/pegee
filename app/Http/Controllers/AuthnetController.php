<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\OrderTransactionDetail;
use App\Product;
use Auth;
use \Cart as Cart;
use App\Mail\SingleProductOrderUpdate;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Support\Facades\Config;
use DateTime;
use App\EmailTemplate;
use Illuminate\Support\Facades\Log;
use App\AuthorizeTransactionLog;

class AuthnetController extends Controller
{

    /**
     * @var $merchantAuthentication
     */
    protected $merchantAuthentication;

    public function __construct()
    {
        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $this->merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));
    }

    public function cancelSubscription($subscriptionId)
    {

        $orderDetail = OrderDetail::where('subscription_id', $subscriptionId)->first();

        $orderTransactionDetail = OrderTransactionDetail::where('order_detail_id', $orderDetail->id)->first();

        // Set the transaction's refId
        $refId = $orderDetail->getOrder->order_no;
        $request = new AnetAPI\ARBCancelSubscriptionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);
        $controller = new AnetController\ARBCancelSubscriptionController($request);
        if (env('APP_ENV') == "production") {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        } else {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }
        if (($response != null) && ($response->getMessages()->getResultCode() == env('ANET_RESPONSE_OK'))) {
//            $successMessages = $response->getMessages()->getMessage();
            $orderDetail->subscription_status = 2;
            $orderDetail->save();

            $customer_cancel_subscription_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_CANCEL_SUBSCRIPTION_EMAIL)
                ->where('is_active', 1)
                ->first();
            if ($customer_cancel_subscription_email_template) {
                try {
                    \Mail::to($orderDetail->getOrder->email)->send(new SingleProductOrderUpdate($orderDetail, $customer_cancel_subscription_email_template));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }

            $admin_cancel_subscription_email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_CANCEL_SUBSCRIPTION_EMAIL)
                ->where('is_active', 1)
                ->first();

            if ($admin_cancel_subscription_email_template) {
                try {
                    \Mail::to(env('PAYMENT_APPROVED_EMAIL'))->send(new SingleProductOrderUpdate($orderDetail, $admin_cancel_subscription_email_template));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }

            return redirect()->route('order.detail', $orderDetail->getOrder->order_no)->with('success', 'Your subscription cancelled!');
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            $orderDetail->error_code = $errorMessages[0]->getCode();
            $orderDetail->save();
            return redirect()->route('order.detail', $orderDetail->getOrder->order_no)->with('error', 'Some error occour please try later!');
        }
    }

    public function getUpdateSubscription($id)
    {
        $orderDetail = OrderDetail::where('subscription_id', $id)->first();
        $autoShips = Config::get('constants.AUTOSHIPS');
        return view('order.update-subscription', [
            'orderDetail' => $orderDetail,
            'autoShips' => $autoShips,
            'title' => 'Update Subscription',
        ]);
    }

    public function updateSubscription(Request $inputRequest)
    {

        $orderDetail = OrderDetail::where('subscription_id', $inputRequest->input('subscription_id'))->first();

        $orderTransactionDetail = OrderTransactionDetail::where('order_detail_id', $orderDetail->id)->first();
        $expirationDate = $inputRequest->input('expYear') . '-' . $inputRequest->input('expMonth');


        // Set the transaction's refId
        $refId = $orderDetail->getOrder->order_no;
        $subscription = new AnetAPI\ARBSubscriptionType();

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($inputRequest->input('cardNumber'));
        $creditCard->setExpirationDate($expirationDate);


        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        $subscription->setPayment($payment);

        $request = new AnetAPI\ARBUpdateSubscriptionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($inputRequest->input('subscription_id'));
        $request->setSubscription($subscription);


        $controller = new AnetController\ARBUpdateSubscriptionController($request);
        if (env('APP_ENV') == "production") {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        } else {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }

        if (($response != null) && ($response->getMessages()->getResultCode() == env('ANET_RESPONSE_OK'))) {
//            $successMessages = $response->getMessages()->getMessage();
            $email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_UPDATE_SUBSCRIPTION_EMAIL)
                ->where('is_active', 1)
                ->first();
            if ($email_template) {
                try {
                    \Mail::to($orderDetail->getOrder->email)->send(new SingleProductOrderUpdate($orderDetail, $email_template));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }
            return redirect()->route('order.detail', $orderDetail->getOrder->order_no)->with('success', 'Your subscription updated!');
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            $orderDetail->error_code = $errorMessages[0]->getCode();
            $orderDetail->save();
            return redirect()->route('order.detail', $orderDetail->getOrder->order_no)->with('error', 'Some error occur please try later!');
        }
    }

    public function subscriptionTransactionCallback()
    {
        $payload = file_get_contents("php://input");
        $payload = \GuzzleHttp\json_decode($payload);
        $transactionId = $payload->payload->id;
        Log::debug("CALLBACK TRANSACTION ID: " . $transactionId);
        $authorizeTransactionLog = AuthorizeTransactionLog::where('transaction_id', $transactionId)->first();
        if($authorizeTransactionLog) {
            $authorizeTransactionLog->attempts  += 1;
        }else{
            $authorizeTransactionLog = new AuthorizeTransactionLog();
        }
        $authorizeTransactionLog->is_processed = true;
        $authorizeTransactionLog->message = "PROCESSED SUCCESSFULLY";
        $authorizeTransactionLog->transaction_id = $transactionId;
        $request = new AnetAPI\GetTransactionDetailsRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setTransId($transactionId);
        $controller = new AnetController\GetTransactionDetailsController($request);
        if (env('APP_ENV') == "production") {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        } else {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }
        if (($response != null) && ($response->getMessages()->getResultCode() == env('ANET_RESPONSE_OK'))) {
            // subscription transaction Logic
            $orderTransactionDetail = OrderTransactionDetail::where('transaction_id', $transactionId)->first();
            if ($response->getTransaction()->getSubscription() != NULL) {
                if (!$orderTransactionDetail) {

                    $orderTransactionDetail = new OrderTransactionDetail();
                    $orderTransactionDetail->transaction_id = $transactionId;
                    $orderTransactionDetail->date_time = date('Y-m-d H:i:s');
                    $orderTransactionDetail->shipping_status = 1;
                }
                $subscriptionId = $response->getTransaction()->getSubscription()->getId();
                $authorizeTransactionLog->subscription_id = $subscriptionId;
                Log::debug("CALLBACK SUBSCRIPTION ID: " . $subscriptionId);
                $orderDetail = OrderDetail::where('subscription_id', $subscriptionId)->first();
                if ($orderDetail) {
                    Log::debug("CALLBACK ORDER DETAIL FOUND FOR :" . $subscriptionId);
                    $orderTransactionDetail->order_id = $orderDetail->getOrder->id;
                    $authorizeTransactionLog->order_id = $orderTransactionDetail->order_id;
                    $orderTransactionDetail->order_detail_id = $orderDetail->id;
                    $orderTransactionDetail->credit_card_number = $response->getTransaction()->getPayment()->getCreditCard()->getCardNumber();
                    if ($response->getTransaction()->getTransactionStatus() == "settledSuccessfully") {
                        $orderTransactionDetail->payment_status = 1;
                        $orderTransactionDetail->transaction_amount = $response->getTransaction()->getSettleAmount();
                    } else if ($response->getTransaction()->getTransactionStatus() == "capturedPendingSettlement") {
                        $orderTransactionDetail->payment_status = 5;
                        $orderTransactionDetail->transaction_amount = $response->getTransaction()->getAuthAmount();
                    }
                    $orderTransactionDetail->save();
                } else {
                    $authorizeTransactionLog->is_processed = false;
                    $authorizeTransactionLog->message = 'CALLBACK ORDER NOT DETAIL FOUND FOR ' . $subscriptionId;
                    Log::debug("CALLBACK ORDER NOT DETAIL FOUND FOR :" . $subscriptionId);
                }
            } else {

                // simple transaction Logic
                // getting payment settlement then update the payment status paid
                if($orderTransactionDetail){
                    Log::debug("PAYMENT SETTLEMENT FOR TRANSACTION ID: " . $transactionId);
                    if ($response->getTransaction()->getTransactionStatus() == "settledSuccessfully") {
                        $orderTransactionDetail->payment_status = 1;
                        $orderTransactionDetail->transaction_amount = $response->getTransaction()->getSettleAmount();
                    } else if ($response->getTransaction()->getTransactionStatus() == "capturedPendingSettlement") {
                        $orderTransactionDetail->transaction_amount = $response->getTransaction()->getAuthAmount();
                        $orderTransactionDetail->payment_status = 5;
                    }
                    $orderTransactionDetail->save();
                }else{
                    $authorizeTransactionLog->is_processed = false;
                    $authorizeTransactionLog->message = "Unable to process this transaction due to insufficent data from Authorize.net API";
                }
            }
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            $messageText = "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
            $authorizeTransactionLog->is_processed = false;
            $authorizeTransactionLog->message = $messageText;
            Log::debug("CALLBACK Invalid response: " . $messageText);
////            echo "ERROR :  Invalid response\n";
//            $errorMessages = $response->getMessages()->getMessage();
////            echo "Response : " . $errorMessages[0]->getCode() . "  " . $errorMessages[0]->getText() . "\n";
//            $orderTransactionDetail->error_code = $errorMessages[0]->getCode();
//            $orderTransactionDetail->error_description = $errorMessages[0]->getText();
        }
        $authorizeTransactionLog->save();

        exit;
    }

}
