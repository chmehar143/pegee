<?php

namespace App\Http\Controllers;

use App\Product;
use App\Order;
use Auth;
use \Cart as Cart;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Mail\OrderMail;

class PayPalController extends Controller {

    /**
     * @var ExpressCheckout
     */
    protected $provider;

    public function __construct() {
        $this->provider = new ExpressCheckout();
    }

    public function getExpressCheckout(Request $request) {
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $order_id = intval($request->get('order_id'));

        $cart = $this->getCheckoutData($recurring, $order_id);

        try {
            $options = [
                'BRANDNAME' => 'PetsWorld',
                'CHANNELTYPE' => 'Merchant'
            ];

            $response = $this->provider->addOptions($options)->setExpressCheckout($cart, $recurring);

            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            $order = Order::findOrFail($order_id);
            if ($order->delete()) {
                return redirect()->route('cart.index')->with('error', 'Error processing PayPal payment Please Try Later!');
            } else {
                return redirect()->route('cart.index')->with('error', 'Error processing PayPal payment Please Try Later!');
            }
        }
    }

    public function getExpressCheckoutSuccess(Request $request) {
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        $cart = $this->getCheckoutData($recurring, intval($response['PAYMENTREQUEST_0_INVNUM']));

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            if ($recurring === true) {
                $response = $this->provider->createMonthlySubscription($response['TOKEN'], 9.99, $cart['subscription_desc']);
                if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                    $status = 'Processed';
                } else {
                    $status = 'Invalid';
                }
            } else {
                // Perform transaction on PayPal
                $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
                $transaction_id = $payment_status['PAYMENTINFO_0_TRANSACTIONID'];
            }

            $order = Order::findOrFail($response['PAYMENTREQUEST_0_INVNUM']);
            if ($status == 'Completed' || $status == 'Processed') {
                if (!is_null($order) && count($order) > 0) {
                    foreach ($order->getOrderDetails as $orderDetail) {
                        $product = Product::findOrFail($orderDetail->product_id);
                        $product->product_quantity = $product->product_quantity - $orderDetail->quantity;
                        $product->save();
                    }
                    $order->payment_status = 1;
                    $order->transaction_id = $transaction_id;
                }
            } else {
                $order->payment_status = 4;
                $order->transaction_id = NULL;
            }

            if ($order->save()) {
                \Mail::to($order)->send(new OrderMail($order));
                return redirect()->route('confirm.order');
            } else {
                return redirect()->route('cart.index')->with('error', 'Error processing PayPal payment for Order!');
            }
        }
    }

    protected function getCheckoutData($recurring = false, $order_id) {
        $data = [];
        $invoice_id = Order::findOrFail($order_id);

        if ($recurring === true) {
            $data['items'] = [
                [
                    'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id->id,
                    'price' => 0,
                    'qty' => 1,
                ],
            ];

            $data['return_url'] = url('/paypal/checkout-success?mode=recurring');
            $data['subscription_desc'] = 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $order_id;
        } else {
            $price = 0;
            $discount = 0;
            $discountedPrice = 0;
            $carts = Cart::content();
            $data['items'] = [];
            foreach ($carts as $cart) {
                $cartQty = intval($cart->qty);
                $product = Product::findorfail($cart->id);
                $discountedPrice = $product->price;
                if ($product->getActiveOffers()->count() > 0) {
                    foreach ($product->getActiveOffers() as $offer) {
                        if ($offer->quantity == $cartQty) {
                            $discount = ($product->price * $offer->offer) / 100;
                            $discountedPrice = $product->price - $discount;
                        }
                    }
                }
                $data['items'][] = [
                    'name' => $product->name,
                    'price' => number_format(round($discountedPrice, 2), 2),
                    'qty' => $cartQty
                ];
            }

            $data['return_url'] = url('/paypal/checkout-success');
        }

        $data['invoice_id'] = $invoice_id->id;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['cancel_url'] = url('paypal/cancel-request');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = number_format(round($total, 2), 2);

        return $data;
    }

    public function getCancelRequest(Request $request) {
        $token = $request->get('token');
        $response = $this->provider->getExpressCheckoutDetails($token);
        $order = Order::findOrFail($response['PAYMENTREQUEST_0_INVNUM']);
        if ($order->delete()) {
            return redirect()->route('cart.index')->with('success', 'Order has been Cancelled successfully!');
        } else {
            return redirect()->route('cart.index')->with('error', 'Some Error Occour!');
        }
    }

    public function getConfirmOrder() {
        if (Auth::user()) {
            Cart::destroy();
            Cart::restore(Auth::user()->id);
            Cart::destroy();
            return redirect()->route('cart.index')->with('success', 'Order has been paid successfully!');
        } else {
            Cart::destroy();
            return redirect()->route('cart.index')->with('success', 'Order has been paid successfully!');
        }
    }

}
