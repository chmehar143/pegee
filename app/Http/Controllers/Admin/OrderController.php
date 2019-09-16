<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\OrderDetail;
use App\OrderTransactionDetail;
use App\Product;
use App\Category;
use App\Offer;
use App\Status;
use Illuminate\Support\Facades\Config;
use App\ModelFilters\AdminFilters\OrderFilter;
use App\ModelFilters\AdminFilters\OrderTransactionDetailFilter;
use Illuminate\Http\Request;
use App\Http\Requests\AdminOrderRequest;
use Carbon\Carbon;
use CountryState;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin.auth')->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 'index-order';
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();
        $statuses = Status::all();
        $orderStatus = Config::get('constants.ORDERSTATUS');
        $paymentStatus = Config::get('constants.PAYMENTSTATUS');
        $subscriptionStatus = Config::get('constants.SUBSCRIPTIONSTATUS');
        $autoships = Config::get('constants.AUTOSHIPS');
        $orders = Order::filter($request->all(), OrderFilter::class)
            ->latest()
            ->paginateFilter(10);
        return view('admin.order.index', [
            'orders' => $orders,
            'states' => $states,
            'countries' => $countries,
            'page' => $page,
            'statuses' => $statuses,
            'orderStatus' => $orderStatus,
            'paymentStatus' => $paymentStatus,
            'subscriptionStatus' => $subscriptionStatus,
            'autoships' => $autoships
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();
        $order = Order::findOrFail($id);
        $orderStatus = Config::get('constants.ORDERSTATUS');
        $paymentStatus = Config::get('constants.PAYMENTSTATUS');
        $autoships = Config::get('constants.AUTOSHIPS');
        $subscriptionStatus = Config::get('constants.SUBSCRIPTIONSTATUS');
        return view('admin.order.show', [
            'order' => $order,
            'states' => $states,
            'countries' => $countries,
            'orderStatus' => $orderStatus,
            'paymentStatus' => $paymentStatus,
            'autoships' => $autoships,
            'subscriptionStatus' => $subscriptionStatus,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $statuses = Status::all();
        $tracking_service_providers = [
            OrderTransactionDetail::TRACKING_TYPE_UPS,
            OrderTransactionDetail::TRACKING_TYPE_FEDEX,
        ];
        $order = OrderTransactionDetail::findOrFail($id);
        return view('admin.order.edit', [
            'statuses' => $statuses,
            'order' => $order,
            'tracking_service_providers' => $tracking_service_providers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminOrderRequest $request, $id)
    {
        $order = OrderTransactionDetail::findOrFail($id);
        $order->shipping_status = $request->input('status');
        $order->tracking_id = $request->input('tracking_id');
        $order->tracking_type = $request->input('tracking_type');
        if ($order->save()) {
            // send your order has been shipped email
            if ($order->tracking_id && $order->tracking_type) {
                $order->prepareShipmentTracking();
            }

            return redirect()->route('order.show', $order->order_id)->with('success', 'Order Shipping status was successfully updated!');
        } else {
            return redirect()->route('order.show', $order->order_id)->with('error', 'Some Error Occour!');
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
        //
    }

    public function orderInvoice($id)
    {
        $orderTransactionalDetail = OrderTransactionDetail::findOrFail($id);
        $orderStatus = Config::get('constants.ORDERSTATUS');
        $paymentStatus = Config::get('constants.PAYMENTSTATUS');
        $autoships = Config::get('constants.AUTOSHIPS');
        $subscriptionStatus = Config::get('constants.SUBSCRIPTIONSTATUS');
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();
        return view('admin.order.invoice', [
                'orderTransactionalDetail' => $orderTransactionalDetail,
                'states' => $states,
                'countries' => $countries,
                'orderStatus' => $orderStatus,
                'paymentStatus' => $paymentStatus,
                'autoships' => $autoships,
                'subscriptionStatus' => $subscriptionStatus,
            ]
        );
    }


    public function getSubscriptionTransactions($orderDetailId)
    {
        $orderDetail = OrderDetail::findOrFail($orderDetailId);
        $order = $orderDetail->getOrder;
        $orderStatus = Config::get('constants.ORDERSTATUS');
        $paymentStatus = Config::get('constants.PAYMENTSTATUS');
        $autoships = Config::get('constants.AUTOSHIPS');
        $subscriptionStatus = Config::get('constants.SUBSCRIPTIONSTATUS');
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();

        return view('admin.order.subscription_transactions', [
            'detail' => $orderDetail,
            'order' => $order,
            'states' => $states,
            'countries' => $countries,
            'orderStatus' => $orderStatus,
            'paymentStatus' => $paymentStatus,
            'autoships' => $autoships,
            'subscriptionStatus' => $subscriptionStatus,
        ]);

    }

    public function getPendingOrders()
    {
        $page = 'pending-orders';
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();
        $statuses = Status::all();
        $orderStatus = Config::get('constants.ORDERSTATUS');
        $paymentStatus = Config::get('constants.PAYMENTSTATUS');
        $subscriptionStatus = Config::get('constants.SUBSCRIPTIONSTATUS');
        $autoships = Config::get('constants.AUTOSHIPS');
        $orders = Order::getPendingOrders();
        return view('admin.order.pending', [
            'orders' => $orders,
            'states' => $states,
            'countries' => $countries,
            'page' => $page,
            'statuses' => $statuses,
            'orderStatus' => $orderStatus,
            'paymentStatus' => $paymentStatus,
            'subscriptionStatus' => $subscriptionStatus,
            'autoships' => $autoships
        ]);
    }

    public function getUpdateOrderAddress($order_no)
    {
        $order = Order::where('order_no', $order_no)->first();
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();

        return view('admin.order.update-address', [
            'order' => $order,
            'countries' => $countries,
            'states' => $states

        ]);
    }

    public function updateOrderAddress(Request $request, $order_no)
    {

        $order = Order::where('order_no', $order_no)->first();
        $order->street = $request->get('street');
        $order->street2 = $request->get('street2');
        $order->city = $request->get('city');
        $order->state = $request->get('state');
        $order->postal_code = $request->get('postal_code');
        $order->country = $request->get('country');
        $order->save();
        return redirect()->route('order.show', $order->id)->with('success', 'Order Address has been updated successfully!');

    }

}
