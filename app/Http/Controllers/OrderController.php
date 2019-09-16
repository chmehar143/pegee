<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderDetail;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TrackOrderRequest;
use CountryState;
use Illuminate\Support\Facades\Config;
use App\MetaTag;

class OrderController extends Controller {

    public function getOrders() {
        if (Auth::user()) {
            $orders = Order::where('user_id', Auth::user()->id)
                    ->latest()
                    ->paginate(10);
            $orderStatus = Config::get('constants.ORDERSTATUS');
            $paymentStatus = Config::get('constants.PAYMENTSTATUS');
            $meta_tags = MetaTag::getMetas('my-orders-page', 1);
            return view('order.order', [
                'orders' => $orders,
                'orderStatus' => $orderStatus,
                'paymentStatus' => $paymentStatus,
                'page' => 'order',
                'title' => 'Your Orders',
                'meta_tags' => $meta_tags
            ]);
        } else {
            return redirect()->route('login')->with('error', 'You need to login for accessing the orders page!');
        }
    }

    public function getTrack() {
        $meta_tags = MetaTag::getMetas('track-page', 1);
        return view('order.track', ['title' => 'Track Order', 'meta_tags' => $meta_tags]);
    }

    public function getTrackDetail(TrackOrderRequest $request) {
        $track = $request->input('track');
        $order = Order::where('order_no', $track)->first();
        $orderStatus = Config::get('constants.ORDERSTATUS');
        $paymentStatus = Config::get('constants.PAYMENTSTATUS');
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();
        $autoships = Config::get('constants.AUTOSHIPS');
        $subscriptionStatus = Config::get('constants.SUBSCRIPTIONSTATUS');
        $orderCountUser = NULL;
        if (Auth::user()) {
            $orderUserId = Auth::user()->id;
            $orderCountUser = Order::where('user_id', $orderUserId)->first();
        }
        $meta_tags = MetaTag::getMetas('track-page', 1);
        return view('order.detail', [
            'order' => $order,
            'orderStatus' => $orderStatus,
            'paymentStatus' => $paymentStatus,
            'states' => $states,
            'countries' => $countries,
            'page' => 'order',
            'title' => 'Your Order Details',
            'autoships' => $autoships,
            'subscriptionStatus' => $subscriptionStatus,
            'orderCountUser' => $orderCountUser,
            'meta_tags' => $meta_tags
        ]);
    }

    public function getOrderdetails($order_id) {
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();
        $order = Order::where('order_no', $order_id)->first();
        $orderStatus = Config::get('constants.ORDERSTATUS');
        $paymentStatus = Config::get('constants.PAYMENTSTATUS');
        $autoships = Config::get('constants.AUTOSHIPS');
        $subscriptionStatus = Config::get('constants.SUBSCRIPTIONSTATUS');
        $orderCountUser = NULL;
        if (Auth::user()) {
            $orderUserId = Auth::user()->id;
            $orderCountUser = Order::where('user_id', $orderUserId)->first();
        }
        $meta_tags = MetaTag::getMetas('order-detail-page', 1);
        return view('order.detail', [
            'order' => $order,
            'orderStatus' => $orderStatus,
            'paymentStatus' => $paymentStatus,
            'states' => $states,
            'countries' => $countries,
            'page' => 'order',
            'title' => 'Your Order Details',
            'autoships' => $autoships,
            'subscriptionStatus' => $subscriptionStatus,
            'orderCountUser' => $orderCountUser,
            'meta_tags' => $meta_tags
        ]);
    }

    public function orderSuccess($order_id){
        $order = Order::where('order_no', $order_id)->first();
        return view('order.success', ['order' => $order]);
    }

    public function getUpdateOrderAddress($order_no){
        $order = Order::where('order_no', $order_no)->first();
        $states = CountryState::getStates('US');
        $countries = CountryState::getCountries();
        $meta_tags = MetaTag::getMetas('order-detail-page', 1);
        return view('order.update-address', [
            'order' => $order,
            'meta_tags' => $meta_tags,
            'countries' => $countries,
            'title' => 'Update order address',
            'states' => $states

        ]);
    }

    public function updateOrderAddress(Request $request, $order_no){
        if (Auth::user()) {
            $order = Order::where('order_no', $order_no)->first();
            $order->street = $request->get('street');
            $order->street2 = $request->get('street2');
            $order->city = $request->get('city');
            $order->state = $request->get('state');
            $order->postal_code = $request->get('postal_code');
            $order->country = $request->get('country');
            $order->save();
            return redirect()->route('order.detail', $order->order_no)->with('success', 'Order Address has been updated successfully!');
        }else{
            return redirect()->route('login')->with('error', 'You need to login for accessing the orders page!');
        }


    }



}
