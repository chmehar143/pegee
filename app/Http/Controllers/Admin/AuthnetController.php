<?php

namespace App\Http\Controllers\Admin;


use App\Order;
use App\OrderDetail;
use App\OrderTransactionDetail;
use App\Http\Controllers\Controller;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use App\Mail\SingleProductOrderUpdate;
use App\EmailTemplate;
use Illuminate\Support\Facades\Log;

class AuthnetController extends Controller
{

    /**
     * @var $merchantAuthentication
     */
    protected $merchantAuthentication;

    public function __construct()
    {

        $this->middleware('admin.auth')->except('logout');

        $this->merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchantAuthentication->setName(env('ANET_API_LOGIN_ID'));
        $this->merchantAuthentication->setTransactionKey(env('ANET_TRANSACTION_KEY'));
    }

    public function refundTransaction($order_detail_id)
    {

        $amount = 0;

        $orderDetail = OrderDetail::findOrFail($order_detail_id);

        $orderTransactionDetail = OrderTransactionDetail::where('order_detail_id', $order_detail_id)->first();

        $refTransId = $orderTransactionDetail->transaction_id;

        $request = new AnetAPI\GetTransactionDetailsRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setTransId($refTransId);
        $controller = new AnetController\GetTransactionDetailsController($request);

        if (env('APP_ENV') == "production") {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        } else {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }

        if (($response != null) && ($response->getMessages()->getResultCode() == env('ANET_RESPONSE_OK'))) {
            if ($response->getTransaction()->getTransactionStatus() == "settledSuccessfully") {
                $amount = $response->getTransaction()->getSettleAmount();
            } else if ($response->getTransaction()->getTransactionStatus() == "capturedPendingSettlement") {
                return redirect()->route('order.show', $orderDetail->order_id)->with('error', 'Payment Captured Pending Settlement');
            } else {
                return redirect()->route('order.show', $orderDetail->order_id)->with('error', 'Payment Not Settled');
            }
        }

        // Set the transaction's refId
        $refId = $orderDetail->getOrder->order_no;

        $creditCardNumber = $orderTransactionDetail->credit_card_number;
        $creditCardNumber = preg_replace("/XXXX/", "", $creditCardNumber);

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($creditCardNumber);
        $creditCard->setExpirationDate("XXXX");
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        //create a transaction
        $transactionRequest = new AnetAPI\TransactionRequestType();
        $transactionRequest->setTransactionType("refundTransaction");
        $transactionRequest->setAmount($amount);
        $transactionRequest->setPayment($paymentOne);
        $transactionRequest->setRefTransId($refTransId);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequest);
        $controller = new AnetController\CreateTransactionController($request);
        if (env('APP_ENV') == "production") {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        } else {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }
        if ($response != null) {
            if ($response->getMessages()->getResultCode() == env('ANET_RESPONSE_OK')) {
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $orderTransactionDetail->payment_status = 3;
                    $orderTransactionDetail->shipping_status = 5;
                    $orderTransactionDetail->refund_transaction_response_code = $tresponse->getResponseCode();
                    $orderTransactionDetail->refund_success_code = $tresponse->getTransId();
                    $orderTransactionDetail->refund_code = $tresponse->getMessages()[0]->getCode();
                    $orderTransactionDetail->refund_description = $tresponse->getMessages()[0]->getDescription();
                    $orderTransactionDetail->save();
                    $customer_refund_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_REFUND_TRANSACTION_EMAIL)
                        ->where('is_active', 1)
                        ->first();
                    if ($customer_refund_email_template) {
                        try{
                            \Mail::to($orderDetail->getOrder->email)->send(new SingleProductOrderUpdate($orderDetail, $customer_refund_email_template));
                        } catch (\Exception $e) {
                            Log::warning($e->getMessage());
                        }
                    }

                    $admin_refund_email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_REFUND_TRANSACTION_EMAIL)
                        ->where('is_active', 1)
                        ->first();
                    if ($admin_refund_email_template) {
                        try{
                            \Mail::to(env('PAYMENT_APPROVED_EMAIL'))->send(new SingleProductOrderUpdate($orderDetail, $admin_refund_email_template));
                        } catch (\Exception $e) {
                            Log::warning($e->getMessage());
                        }
                    }

                    return redirect()->route('order.show', $orderDetail->order_id)->with('success', $tresponse->getMessages()[0]->getDescription());
                } else {
                    if ($tresponse->getErrors() != null) {
                        $orderTransactionDetail->error_code = $tresponse->getErrors()[0]->getErrorCode();
                        $orderTransactionDetail->error_description = $tresponse->getErrors()[0]->getErrorText();
                        $orderTransactionDetail->save();
                        return redirect()->route('order.show', $orderDetail->order_id)->with('error', $tresponse->getErrors()[0]->getErrorText());
                    }
                }
            } else {
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $orderTransactionDetail->error_code = $tresponse->getErrors()[0]->getErrorCode();
                    $orderTransactionDetail->error_description = $tresponse->getErrors()[0]->getErrorText();
                    $orderTransactionDetail->save();
                    return redirect()->route('order.show', $orderDetail->order_id)->with('error', $response->getMessages()->getMessage()[0]->getText());
                } else {
                    $orderTransactionDetail->error_code = $response->getMessages()->getMessage()[0]->getCode();
                    $orderTransactionDetail->error_description = $response->getMessages()->getMessage()[0]->getText();
                    $orderTransactionDetail->save();
                    return redirect()->route('order.show', $orderDetail->order_id)->with('error', $response->getMessages()->getMessage()[0]->getText());
                }
            }
        } else {
            return redirect()->route('order.show', $orderDetail->order_id)->with('error', 'Some Error Occour!');
        }
    }

}
