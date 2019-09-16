@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h2 class="title">Your Order Details</h2>
            </div>
        </div>

        <section class="divider">
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a> {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a> {{ session('error') }}
                    </div>
                @endif
                <div class="section-content">
                    @if($order)
                        <div class="row">

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered tbl-shopping-cart">
                                        <thead>
                                        <tr>
                                            <th colspan="8">Shipping
                                                Details {{ ($order->billing_bit == 1) ? '& Billing Details' : '' }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td colspan="8">
                                                <strong>Your Order No</strong>&nbsp;
                                                {{ $order->order_no }}
                                                <br/>
                                                <strong>First Name</strong>
                                                {{ $order->first_name }}
                                                <br/>
                                                <strong>Last Name</strong>
                                                {{ $order->last_name }}
                                                <br/>
                                                @if (Auth::user())
                                                    <strong>Company</strong>
                                                    {{ $order->company }}
                                                    <br/>
                                                    <strong>Phone No</strong>
                                                    {{ $order->phone }}
                                                    <br/>
                                                    <strong>Email</strong>
                                                    {{ $order->email }}
                                                    <br/>
                                                @endif
                                                <strong>Street</strong>
                                                {{ $order->street }}
                                                <br/>
                                                @if(!is_null($order->street2))
                                                    <strong>Street 2</strong>
                                                    {{ $order->street2 }}
                                                    <br/>
                                                @endif
                                                <strong>City</strong>
                                                {{ $order->city }}
                                                <br/>
                                                <strong>State</strong>
                                                {{ $states[$order->state] }}
                                                <br/>
                                                <strong>Postal Code</strong>
                                                {{ $order->postal_code }}
                                                <br/>
                                                <strong>Country</strong>
                                                {{ $countries[$order->country] }}
                                                <br/>
                                            </td>
                                        </tr>
                                        <tr>
                                            @if(Auth::user() && $order->user_id == Auth::user()->id)
                                                <td class="text-right" colspan="5">
                                                    <a class="btn btn-theme-colored btn-circled"
                                                       href="{{ route('order.address-update', $order->order_no )}}">Update
                                                        Order Address</a>
                                                </td>
                                            @endif
                                        </tr>
                                        </tbody>
                                        @if($order->billing_bit == 0 && $order->b_street != NULL)
                                            <thead>
                                            <tr>
                                                <th colspan="8">Billing Details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="8">
                                                    <strong>Address</strong>&nbsp;
                                                    {{ $order->b_street }}
                                                    <br/>
                                                    @if(!is_null($order->b_street2))
                                                        <strong>Address (Optional)</strong>
                                                        {{ $order->b_street2 }}
                                                        <br/>
                                                    @endif
                                                    <strong>City</strong>
                                                    {{ $order->b_city }}
                                                    <br/>
                                                    <strong>State</strong>
                                                    {{ $states[$order->b_state] }}
                                                    <br/>
                                                    <strong>Postal Code</strong>
                                                    {{ $order->b_postal_code }}
                                                    <br/>
                                                    <strong>Phone No</strong>
                                                    {{ $order->b_phone_no }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        @endif
                                    </table>

                                    @foreach($order->getOrderDetails as $detail)
                                        <table class="table table-bordered tbl-shopping-cart">
                                            <thead>
                                            <tr>
                                                <th colspan="8">Order Details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="8">
                                                    <strong>Product Purchased:</strong>&nbsp;
                                                    {{ $detail->getProductDetail->name }}
                                                    <br/>
                                                    <strong>Product Price: </strong>&nbsp;
                                                    ${{ $detail->price }}
                                                    <br/>
                                                    <strong>Product Quantity: </strong>&nbsp;
                                                    {{ $detail->quantity }}
                                                    <br/>
                                                    @if($detail->special_discount == 0)
                                                        @if($detail->discount > 0)
                                                            <strong>Discount: </strong>&nbsp;
                                                            {{ $detail->discount }}%
                                                        @endif
                                                    @else
                                                        <strong>Initial Order Discount: </strong>&nbsp;
                                                        15%
                                                        <br/>
                                                    @endif
                                                    @if($detail->autoship_discount > 0 && $detail->autoship_interval > 0)
                                                        <strong>Autoship Discount: </strong>&nbsp;
                                                        {{ $detail->autoship_discount }}%
                                                        <br/>
                                                        <strong>Autoship Interval: </strong>&nbsp;
                                                        Ship {{ $autoships[$detail->autoship_interval] }}
                                                        <br/>
                                                    @endif
                                                    @if($detail->subscription_status > 0)
                                                        <strong>Subscription Status: </strong>&nbsp;
                                                        @if($detail->subscription_status == 1)
                                                            <span class="label label-success">{{ $subscriptionStatus[$detail->subscription_status] }}</span>
                                                        @elseif($detail->subscription_status == 2)
                                                            <span class="label label-danger">{{ $subscriptionStatus[$detail->subscription_status] }}</span>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @if(Auth::user() && $order->user_id == Auth::user()->id)
                                                @if($detail->subscription_status == 1)
                                                    @if($detail->autoship_discount != 0 && $detail->autoship_interval != 0)
                                                        <tr>
                                                            <td class="text-right" colspan="5">
                                                                <a class="btn btn-theme-colored btn-circled"
                                                                   href="{{ route('get.subscription', $detail->subscription_id )}}">Update
                                                                    Subscription</a>
                                                                <a class="btn btn-theme-colored btn-circled"
                                                                   href="{{ route('cancel.subscription', $detail->subscription_id )}}"
                                                                   onclick="return confirm('Are you sure?')">Cancel
                                                                    Subscription</a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endif

                                            </tbody>
                                        </table>
                                        <?php
                                        $transactionDetails = $detail->getTransactions('desc');
                                        $totalTransactions = $transactionDetails->count();
                                        ?>
                                        @if($totalTransactions > 0)

                                            @foreach($transactionDetails as $key => $transactionDetail)
                                                @include('admin/order/_transaction_box', ['totalTransactions' => $totalTransactions, 'hideAllButtons' => true])
                                            @endforeach
                                        @else
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Payment Status</th>
                                                    <th>Shipping Status</th>
                                                    <th>Shipping Tracking</th>
                                                </tr>
                                                <tr>

                                                    <td>{{ Carbon\Carbon::parse($detail->date_time)->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $paymentStatus[5] }}</td>
                                                    <td>{{ $orderStatus[1] }}</td>
                                                    <td>Tracking information is not available. Please check later.</td>
                                                </tr>
                                            </table>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-md-12 mt-30">
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <h4>Initial Order Totals</h4>
                                        <table class="table table-bordered tbl-shopping-cart">
                                            <?php
                                            $cartItems = array();

                                            foreach ($order->getOrderDetails as $detail) {
                                                $cartItems[] = [
                                                    'product' => $detail->getProductDetail,
                                                    'quantity' => $detail->quantity,
                                                    'autoship_enabled' => ($detail->autoship_discount > 0),
                                                    'autoship_discount' => $detail->autoship_discount
                                                ];
                                            }

                                            $calculatedData = getFinalCalculations($cartItems, $order->getUser, $order->isAutoship(), $order->special_discount == 1);
                                            ?>
                                            <tbody>
                                            <tr>
                                                <td>Sub-total</td>
                                                <td>
                                                    ${{ number_format(round($calculatedData['totalPrice'], 2), 2) }}</td>
                                            </tr>
                                            @if($order->special_discount == 1)
                                                <tr>
                                                    <td>15% off first Autoship order</td>
                                                    <td>
                                                        -${{ number_format(round($calculatedData['firstTimeAutoShipDiscount'], 2), 2) }}</td>
                                                </tr>
                                            @endif
                                            @if($order->special_discount == 0)
                                                @foreach($calculatedData['discounts'] as $discount_with_text)
                                                    <tr>
                                                        <td>{{$discount_with_text['text']}}</td>
                                                        <td>
                                                            -${{ number_format(round($discount_with_text['value'], 2), 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td>Autoship Discounts</td>
                                                <td>
                                                    -${{ number_format(round($calculatedData['autoshipDiscount'], 2), 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping FREE</td>
                                                <td>-${{ number_format(0, 2)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Grand Total</td>
                                                <td>
                                                    ${{ number_format(round($calculatedData['grandTotal'], 2), 2) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <a href="{{ route('order') }}" class="btn btn-theme-colored btn-circled">Back to
                                            Orders</a></div>
                                </div>
                            </div>
                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> You have placed no Order
                                </div>
                            @endif
                        </div>
                </div>
            </div>
        </section>
    </div>
@endsection
