<?php

namespace App\Http\Controllers;

use App\EmailTemplate;
use App\MetaTag;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Http\Requests\CheckoutRequest;
use Auth;
use \Cart as Cart;
use CountryState;
use App\Product;
use App\Order;
use App\OrderDetail;
use App\OrderTransactionDetail;
use Validator;
use Illuminate\Support\Facades\Config;
use App\Mail\OrderMail;
use App\Mail\DeclinedOrderMail;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use DateTime;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount = 0;
        $price = 0;
        $data['products'] = [];
        if (Auth::user()) {
            Cart::restore(Auth::user()->id);
            Cart::store(Auth::user()->id);
            if (Cart::count() == 0) {
                Cart::restore(Auth::user()->id);
            }
        }
        if (Cart::count() > 0) {
            $carts = Cart::content();
            foreach ($carts as $cart) {
                $cartQty = intval($cart->qty);
                $product = Product::findorfail($cart->id);
                $price += $product->price * $cartQty;
                $offer = $product->getApllyingOffer($cartQty);
                if ($offer) {
                    $discount += round(($product->price * $offer->offer / 100), 2) * $cartQty;
                }
                $data['products'][$cart->id] = $product;
            }
        }

        $meta_tags = MetaTag::getMetas('view-cart-page', 1);
        return view('cart.index', [
            'price' => $price,
            'discount' => $discount,
            'products' => $data['products'],
            'title' => 'Your Cart',
            'meta_tags' => $meta_tags
        ]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        if (trim($request->input('product_slug')) != "") {
            $product = Product::where('slug', trim($request->input('product_slug')))->firstOrFail();
            $quantity = trim($request->input('quantity'));

            $duplicates = Cart::search(function ($cartItem, $rowId) use ($product) {
                return $cartItem->id === $product->id;
            });

            if (!$duplicates->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Item is already in your cart!');
            }
            Cart::add($product->id, $product->name, $quantity, $product->price)->associate('App\Product');
            return redirect()->route('cart.index')->with('success', 'Item was added to your cart!');
        } else {
            return redirect()->route('cart.index')->with('error', 'Some Error Occour!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Quantity must be Numeric.');
            return response()->json(['success' => false]);
        }

        if (trim($request->quantity) != "" && trim($request->quantity) != 0) {
            if (Auth::user()) {
                if (Cart::count() > 0) {
                    Cart::restore(Auth::user()->id);
                    Cart::update($id, $request->quantity);
                    Cart::store(Auth::user()->id);
                }
            } else {
                Cart::update($id, $request->quantity);
            }
            session()->flash('success', 'Quantity was updated successfully!');

            return response()->json(['success' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (trim($id) != "") {
            if (Auth::user()) {
                Cart::restore(Auth::user()->id);
                Cart::remove($id);
                Cart::store(Auth::user()->id);
            } else {
                Cart::remove($id);
            }

            return redirect()->route('cart.index')->with('success', 'Item has been removed!');
        } else {
            return redirect()->route('cart.index')->with('error', 'Some Error Occour!');
        }
    }

    public function emptyCart()
    {
        if (Auth::user()) {
            Cart::destroy();
            Cart::restore(Auth::user()->id);
        } else {
            Cart::destroy();
        }
        Cart::destroy();
        return redirect()->route('cart.index')->with('success', 'Your cart has been cleared!');
    }

    public function switchToWishlist($id)
    {
        if (trim($id) != "") {
            $item = Cart::get($id);

            if (Auth::user()) {
                Cart::restore(Auth::user()->id);
            }

            Cart::remove($id);

            $duplicates = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($id) {
                return $cartItem->id === $id;
            });

            if (!$duplicates->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Item is already in your Wishlist!');
            }

            Cart::instance('wishlist')->add($item->id, $item->name, $item->qty, $item->price)
                ->associate('App\Product');

            return redirect()->route('cart.index')->with('success', 'Item has been moved to your Wishlist!');
        } else {
            return redirect()->route('cart.index')->with('error', 'Some Error Occour!');
        }
    }

    public function cartCheckout()
    {
        $data = [];
        $cartItems = array();
        if (Cart::count() > 0) {
            $cartContent = Cart::content();
            foreach ($cartContent as $cartItem) {
                $cartItems[] = [
                    'product' => Product::findorfail($cartItem->id),
                    'quantity' => intval($cartItem->qty)
                ];
            }
        }
//        $data = getFinalCalculations($cartItems, Auth::user());
        $data['loggedInUser'] = Auth::user();
        $data['title'] = 'Checkout';
        $data['states'] = CountryState::getStates('US');
        $data['countries'] = CountryState::getCountries();
        $data['autoShips'] = Config::get('constants.AUTOSHIPS');
        $data['cartItems'] = $cartItems;
        $data['meta_tags'] = MetaTag::getMetas('checkout-page', 1);
        return view('cart.cart-checkout', $data);
    }

    public function saveCheckout(CheckoutRequest $request)
    {
        $token = 0;
        do {
            $token = rand(9999, 99999999);
            $result = Order::where('order_no', $token)->get();
        } while (count($result) > 0);
        if (Cart::count() > 0) {
            $order = new Order();
            $order->first_name = $request->input('first_name');
            $order->last_name = $request->input('last_name');
            $order->company = $request->input('company');
            $order->phone = $request->input('phone');
            $order->email = $request->input('email');
            $order->street = $request->input('street');
            $order->street2 = $request->input('street_2');
            $order->city = $request->input('city');
            $order->state = $request->input('state');
            $order->postal_code = $request->input('postal_code');
            $order->country = $request->input('country');
            $order->date_time = date('Y-m-d H:i');
            $order->data_value = $request->input('dataValue');
            $order->data_descriptor = $request->input('dataDescriptor');
            $order->order_no = $token;
            if ($request->input('auto') == 1 && $request->input('autoShip') > 0) {
                $orderCountUser = Order::where('user_id', Auth::user()->id)->get();
                if (count($orderCountUser) == 0) {
                    $order->special_discount = 1;
                }
            }
            $order->user_id = Auth::user() ? Auth::user()->id : NULL;
            if ($request->input('billingCheckBox') == 0) {
                $order->b_street = $request->input('b_street');
                $order->b_street2 = $request->input('b_street_2');
                $order->b_city = $request->input('b_city');
                $order->b_state = $request->input('b_state');
                $order->b_postal_code = $request->input('b_postal_code');
                $order->b_phone_no = $request->input('b_phone_no');
                $order->billing_bit = 0;
            } else {
                $order->billing_bit = 1;
            }
            $order->save();
            $carts = Cart::content();
            foreach ($carts as $cart) {
                $discount = 0;
                $autoShipDiscount = 0;
                $autoShipId = NULL;
                $autoShipInterval = 0;
                $offer_id = NULL;
                $cartQty = intval($cart->qty);
                $product = Product::findorfail($cart->id);
                $offer = $product->getApllyingOffer($cartQty);
                if ($offer) {
                    $offer_id = $offer->id;
                    $discount = $offer->offer;
                }
//                if ($product->getActiveOffers()->count() > 0) {
//                    foreach ($product->getActiveOffers() as $offer) {
//                        if ($offer->quantity == $cartQty) {
//                            $offer_id = $offer->id;
//                            $discount = $offer->offer;
//                        }
//                    }
//                }
                if ($request->input('auto') == 1 && $request->input('autoShip') > 0) {
                    if (!is_null($product->getActiveAutoShip()) && $product->getActiveAutoShip()->count() > 0) {
                        $autoShipDiscount = $product->getActiveAutoShip()->autoship_percentage;
                        $autoShipId = $product->getActiveAutoShip()->id;
                        $autoShipInterval = $request->input('autoShip');
                    }
                }
                $orderDetail = OrderDetail::create([
                    'price' => $product->price,
                    'quantity' => $cartQty,
                    'discount' => $discount,
                    'autoship_discount' => $autoShipDiscount,
                    'autoship_interval' => $autoShipInterval,
                    'date_time' => date('Y-m-d H:i'),
                    'special_discount' => $order->special_discount == 1 ? 1 : 0,
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'offer_id' => $offer_id,
                    'autoship_id' => $autoShipId,
                ]);
                $orderDetail->save();
            }
            $expirationDate = $request->input('expYear') . '-' . $request->input('expMonth');
            return $this->getChargeCreditCard($order->id, $request->input('cardNumber'), $expirationDate, $request->input('cardCode'));
        } else {
            return redirect()->route('checkout')->with('error', 'Some Error Occour!');
        }
    }

    protected function getChargeCreditCard($order_id, $cardNumber, $expirationDate, $cardCode)
    {

        $errorMail = false;

        $customerOrder = Order::findOrFail($order_id);

// Set the transaction's refId
        $refId = $customerOrder->order_no;

// Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($expirationDate);
        $creditCard->setCardCode($cardCode);

// Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $productPrice = 0;
        $discount = 0;
        $autoshipDiscount = 0;
        $amount = 0;
        $specialDiscountMail = 0;
        $specialDiscount = 0;
        $specialAmount = 0;
        $simpleAutoShipDiscount = 0;
        $cartItems = array();
        foreach ($customerOrder->getOrderDetails as $orderDetail) {
            $cartItems[] = ['product' => $orderDetail->getProductDetail, 'quantity' => $orderDetail->quantity];
        }


        foreach ($customerOrder->getOrderDetails as $orderDetails) {
            if ($orderDetails->autoship_discount == 0 && $orderDetails->autoship_interval == 0) {
                $calculatedData = getFinalCalculations($cartItems, Auth::user(), $customerOrder->special_discount == 1, $customerOrder->special_discount == 1);
                $amount = $calculatedData['internalDiscountMapping'][$orderDetails->product_id]['finalPrice'];

// Create order information
                $order = new AnetAPI\OrderType();
                $order->setInvoiceNumber($customerOrder->order_no . "-" . $orderDetails->id);
                $order->setDescription($orderDetails->getProductDetail->name);


// Set the customer's Bill To address
                $shippingAddress = new AnetAPI\CustomerAddressType();
                $shippingAddress->setFirstName($customerOrder->first_name);
                $shippingAddress->setLastName($customerOrder->last_name);
                if (!is_null($customerOrder->company)) {
                    $shippingAddress->setCompany($customerOrder->company);
                }
                $shippingAddress->setAddress($customerOrder->street);
                $shippingAddress->setCity($customerOrder->city);
                $shippingAddress->setState($customerOrder->state);
                $shippingAddress->setZip($customerOrder->postal_code);
                $shippingAddress->setCountry($customerOrder->country);


                $billingAddress = $shippingAddress;
                if ($customerOrder->billing_bit == 0) {
                    $billingAddress = new AnetAPI\CustomerAddressType();
                    $billingAddress->setFirstName($customerOrder->first_name);
                    $billingAddress->setLastName($customerOrder->last_name);
                    if (!is_null($customerOrder->company)) {
                        $billingAddress->setCompany($customerOrder->company);
                    }
                    $billingAddress->setAddress($customerOrder->b_street);
                    $billingAddress->setCity($customerOrder->b_city);
                    $billingAddress->setState($customerOrder->b_state);
                    $billingAddress->setZip($customerOrder->b_postal_code);
                    $billingAddress->setCountry($customerOrder->country);
                }

// Set the customer's identifying information
                $customerData = new AnetAPI\CustomerDataType();
                $customerData->setEmail($customerOrder->email);

// Create a TransactionRequestType object and add the previous objects to it
                $transactionRequestType = new AnetAPI\TransactionRequestType();
                $transactionRequestType->setTransactionType("authCaptureTransaction");
                $transactionRequestType->setAmount($amount);
                $transactionRequestType->setOrder($order);
                $transactionRequestType->setPayment($paymentOne);
                $transactionRequestType->setBillTo($billingAddress);
                $transactionRequestType->setShipTo($shippingAddress);
                $transactionRequestType->setCustomer($customerData);

// Assemble the complete transaction request
                $request = new AnetAPI\CreateTransactionRequest();
                $request->setMerchantAuthentication($this->merchantAuthentication);
                $request->setRefId($refId);
                $request->setTransactionRequest($transactionRequestType);

// Create the controller and get the response
                $controller = new AnetController\CreateTransactionController($request);
                if (env('APP_ENV') == "production") {
                    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                } else {
                    $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                }

                if ($response != null) {
// Check to see if the API request was successfully received and acted upon
                    if ($response->getMessages()->getResultCode() == env('ANET_RESPONSE_OK')) {
// Since the API request was successful, look for a transaction response
// and parse it to display the results of authorizing the card
                        $tresponse = $response->getTransactionResponse();

                        if ($tresponse != null && $tresponse->getMessages() != null) {
                            $product = Product::findOrFail($orderDetails->product_id);
                            $product->product_quantity = $product->product_quantity - $orderDetails->quantity;
                            $product->save();
                            $orderTransactionDetail = new OrderTransactionDetail;
                            $orderTransactionDetail->transaction_id = $tresponse->getTransId();
                            $orderTransactionDetail->date_time = $orderDetails->date_time;
                            $orderTransactionDetail->payment_status = 4;
                            $orderTransactionDetail->shipping_status = 1;
                            $orderTransactionDetail->credit_card_number = $tresponse->getAccountNumber();
                            $orderTransactionDetail->order_id = $customerOrder->id;
                            $orderTransactionDetail->order_detail_id = $orderDetails->id;
                            $orderTransactionDetail->transaction_amount = $amount;
                            $orderTransactionDetail->save();
                        } else {
                            if ($tresponse->getErrors() != null) {
                                $errorMail = true;
                                $orderDetails->error_code = $tresponse->getErrors()[0]->getErrorCode();
                                $orderDetails->error_description = $tresponse->getErrors()[0]->getErrorText();
                                $orderDetails->save();
                            }
                        }
// Or, print errors if the API request wasn't successful
                    } else {
                        $tresponse = $response->getTransactionResponse();

                        if ($tresponse != null && $tresponse->getErrors() != null) {
                            $errorMail = true;
                            $orderDetails->error_code = $tresponse->getErrors()[0]->getErrorCode();
                            $orderDetails->error_description = $tresponse->getErrors()[0]->getErrorText();
                            $orderDetails->save();
                        } else {
                            $errorMail = true;
                            $orderDetails->error_code = $response->getMessages()->getMessage()[0]->getCode();
                            $orderDetails->error_description = $response->getMessages()->getMessage()[0]->getText();
                            $orderDetails->save();
                        }
                    }
                } else {
                    $errorMail = true;
                }
            } else {
                if (Auth::user()) {
                    $calculatedData = getFinalCalculations($cartItems, Auth::user(), true, $customerOrder->special_discount == 1);


                    $specialAmount = $calculatedData['internalDiscountMapping'][$orderDetails->product_id]['finalPrice'];

                    if ($orderDetails->discount != 0) {
                        $discount = getDiscount($orderDetails->price, $orderDetails->discount, $orderDetails->quantity);
                    }

                    $amount = $calculatedData['internalDiscountMapping'][$orderDetails->product_id]['recurringAmount'];
// Subscription Type Info
                    $subscription = new AnetAPI\ARBSubscriptionType();
                    $productName = substr($orderDetails->getProductDetail->name, 0, 30);
                    $subscription->setName($productName);

                    $intervalLength = 7 * $orderDetails->autoship_interval;
                    $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
                    $interval->setLength($intervalLength);
                    $interval->setUnit("days");

                    $paymentSchedule = new AnetAPI\PaymentScheduleType();
                    $paymentSchedule->setInterval($interval);
//                $paymentSchedule->setStartDate(new DateTime(date('Y-m-d', strtotime('+' . $intervalLength . ' days', strtotime($orderDetails->date_time)))));
                    $paymentSchedule->setStartDate(new DateTime(date('Y-m-d')));
                    $paymentSchedule->setTotalOccurrences("9999");
                    if ($orderDetails->autoship_interval != 0) {
                        if (Auth::user()) {
                            $orderUserId = Auth::user()->id;
                            $orderCountUser = Order::where('user_id', $orderUserId)->get();
                            if (count($orderCountUser) == 1) {
                                $paymentSchedule->setTrialOccurrences("1");
                            }
                        }
                    }

                    $subscription->setPaymentSchedule($paymentSchedule);
                    $subscription->setAmount($amount);
                    if ($orderDetails->autoship_interval != 0) {
                        if (Auth::user()) {
                            $orderUserId = Auth::user()->id;
                            $orderCountUser = Order::where('user_id', $orderUserId)->get();
                            if (count($orderCountUser) == 1) {
                                $subscription->setTrialAmount($specialAmount);
                            }
                        }
                    }

                    $subscription->setPayment($paymentOne);

                    $order = new AnetAPI\OrderType();
                    // change on 06-12-2017 order no + order detail id concatenated
                    $order->setInvoiceNumber($customerOrder->order_no . "-" . $orderDetails->id);
                    $order->setDescription($orderDetails->getProductDetail->name . " Subscription");
                    $subscription->setOrder($order);

                    // Set the customer's Bill To address
                    $shippingAddress = new AnetAPI\CustomerAddressType();
                    $shippingAddress->setFirstName($customerOrder->first_name);
                    $shippingAddress->setLastName($customerOrder->last_name);
                    $shippingAddress->setCompany($customerOrder->company);
                    $shippingAddress->setAddress($customerOrder->street);
                    $shippingAddress->setCity($customerOrder->city);
                    $shippingAddress->setState($customerOrder->state);
                    $shippingAddress->setZip($customerOrder->postal_code);
                    $shippingAddress->setCountry($customerOrder->country);


                    $billingAddress = $shippingAddress;
                    if ($customerOrder->billing_bit == 0) {
                        $billingAddress = new AnetAPI\CustomerAddressType();
                        $billingAddress->setFirstName($customerOrder->first_name);
                        $billingAddress->setLastName($customerOrder->last_name);
                        $billingAddress->setCompany($customerOrder->company);
                        $billingAddress->setAddress($customerOrder->b_street);
                        $billingAddress->setCity($customerOrder->b_city);
                        $billingAddress->setState($customerOrder->b_state);
                        $billingAddress->setZip($customerOrder->b_postal_code);
                        $billingAddress->setCountry($customerOrder->country);
                    }

                    $subscription->setBillTo($billingAddress);

                    $subscription->setShipTo($shippingAddress);

                    $request = new AnetAPI\ARBCreateSubscriptionRequest();
                    $request->setmerchantAuthentication($this->merchantAuthentication);
                    $request->setRefId($refId);
                    $request->setSubscription($subscription);
                    $controller = new AnetController\ARBCreateSubscriptionController($request);
                    if (env('APP_ENV') == "production") {
                        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                    } else {
                        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
                    }

                    if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
                        // after subcription created reduced the quantity
                        $product = Product::findOrFail($orderDetails->product_id);
                        $product->product_quantity = $product->product_quantity - $orderDetails->quantity;
                        $product->save();
                        $orderDetails->subscription_id = $response->getSubscriptionId();
                        $orderDetails->subscription_status = 1;
                        $orderDetails->save();
                    } else {
                        $errorMail = true;
                        $errorMessages = $response->getMessages()->getMessage();
                        $orderDetails->error_code = $errorMessages[0]->getCode();
                        $orderDetails->error_description = $errorMessages[0]->getText();
                        $orderDetails->save();
                    }
                } else {
                    \Session::put('previous_url', URL::previous());
                    return redirect()->route('login')->with('error', 'For autoship you need to be a login / signup');
                }
            }
        }
        if ($errorMail == true) {
            /* SEND EMAIL TO CUSTOMER */
            $customer_declined_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_DECLINED_ORDER_EMAIL)
                ->where('is_active', 1)
                ->first();
            if ($customer_declined_email_template) {
                try{
                    \Mail::to($customerOrder)->send(new DeclinedOrderMail($customerOrder, $customer_declined_email_template));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }
            /* SEND EMAIL TO ADMIN */
            $admin_declined_email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_DECLINED_ORDER_EMAIL)
                ->where('is_active', 1)
                ->first();
            if ($admin_declined_email_template) {
                try{
                    \Mail::to(env('PAYMENT_APPROVED_EMAIL'))->send(new DeclinedOrderMail($customerOrder, $admin_declined_email_template));
                } catch (\Exception $e) {
                    Log::warning($e->getMessage());
                }
            }


            return redirect()->route('cart.index')->with('error', 'Error processing payment for order check your email & please try again!');
        }

        /* SEND EMAIL TO CUSTOMER */
        $customer_new_order_email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_NEW_ORDER_EMAIL)
            ->where('is_active', 1)
            ->first();
        if ($customer_new_order_email_template) {
            try{
                \Mail::to($customerOrder)->send(new OrderMail($customerOrder, $customer_new_order_email_template));
            } catch (\Exception $e) {
                Log::warning($e->getMessage());
            }
        }
        /* SEND EMAIL TO ADMIN */
        $admin_new_order_email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_NEW_ORDER_EMAIL)
            ->where('is_active', 1)
            ->first();
        if ($admin_new_order_email_template) {
            try{
                \Mail::to(env('PAYMENT_APPROVED_EMAIL'))->send(new OrderMail($customerOrder, $admin_new_order_email_template));
            } catch (\Exception $e) {
                Log::warning($e->getMessage());
            }
        }

        return redirect()->route('confirm.order', $customerOrder->order_no);
    }

    protected function getConfirmOrder($order_no)
    {
        if (Auth::user()) {
            Cart::destroy();
            Cart::restore(Auth::user()->id);
            Cart::destroy();
        } else {
            Cart::destroy();
        }
        return redirect()->route('order.success', $order_no)->with('success', 'Order has been paid successfully! You received an order details via email');
    }

    public function redirectedToLoginIfAutoship()
    {
        \Session::put("previous_url", URL::previous());
        return redirect()->route('login')->with('error', 'For autoship you need to be a login / signup');
    }

    public function getEmailTestLiveServer()
    {
        $order = Order::where('order_no', 4283168)->first();
//        $customerOrder = Order::first();
//        $customerOrder = Order::findOrFail(542);
        $orderDetail = OrderDetail::findOrFail(23);
        $transaction = OrderTransactionDetail::findOrFail(168);
        /*
        $email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_NEW_ORDER_EMAIL)->first();
        if ($email_template) {
            \Mail::to('kami.eeze@gmail.com')->send(new OrderMail($customerOrder, $email_template));
        }

        $admin_email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_NEW_ORDER_EMAIL)->first();
        if ($admin_email_template) {
            \Mail::to('kami.eeze@gmail.com')->send(new OrderMail($customerOrder, $admin_email_template));
        }
*/
        /*  $email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_DECLINED_ORDER_EMAIL)->first();
          if ($email_template) {
              \Mail::to('kami.eeze@gmail.com')->send(new DeclinedOrderMail($customerOrder, $email_template));
          }*/
        /*
                $email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_DECLINED_ORDER_EMAIL)->first();
        //        dd($email_template);
                if ($email_template) {
                    \Mail::to('kami.eeze@gmail.com')->send(new DeclinedOrderMail($customerOrder, $email_template));
                }
        */
        $email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_PAYMENT_APPROVE_EMAIL)
//        $email_template = EmailTemplate::where('template_type', EmailTemplate::CUSTOMER_UPDATE_SUBSCRIPTION_EMAIL)
            ->where('is_active', 1)
            ->first();
        if ($email_template) {
            \Mail::to('kami.eeze@gmail.com')->send(new \App\Mail\SingleProductOrderUpdate($orderDetail, $email_template, null));
        }

//        $email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_CANCEL_SUBSCRIPTION_EMAIL)
//            ->where('is_active', 1)
//            ->first();
//        if ($email_template) {
//            \Mail::to('kami.eeze@gmail.com')->send(new SingleProductOrderUpdate($orderDetail, $email_template));
//        }
//
        /*
        $email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_REFUND_TRANSACTION_EMAIL)
            ->where('is_active', 1)
            ->first();
        if ($email_template) {
            \Mail::to('kami.eeze@gmail.com')->send(new SingleProductOrderUpdate($orderDetail, $email_template));
        }*/

//        $sample_request = Sample::first();
//
//        $email_template = EmailTemplate::where('template_type', EmailTemplate::ADMIN_SAMPLE_REQUEST_EMAIL)
//            ->where('is_active', 1)
//            ->first();
//        if ($email_template) {
//            \Mail::to('kami.eeze@gmail.com')->send(new RequestSample($sample_request, $email_template));
//        }
//        return redirect()->route('order.success', $order->order_no)->with('success', 'Order has been paid successfully! You received an order details via email');;
    }

}
