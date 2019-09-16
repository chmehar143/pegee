@extends('layouts.admin')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Order
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if($order)
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
                                            <strong>Company</strong>
                                            {{ $order->company }}
                                            <br/>
                                            <strong>Phone No</strong>
                                            {{ $order->phone }}
                                            <br/>
                                            <strong>Email</strong>
                                            {{ $order->email }}
                                            <br/>
                                            <strong>Address</strong>
                                            {{ $order->street }}
                                            <br/>
                                            @if(!is_null($order->street2))
                                                <strong>Address (Optional)</strong>
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
                                        <td>
                                        <div class="text-right">


                                            <a class="btn btn-primary"
                                               href="{{ route('admin.order.address-update', $order->order_no )}}">Update
                                                Order Address</a>
                                        </div>
                                        </td>


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

                                <table class="table table-condensed data-table">
                                    <thead>
                                    <tr>
                                        <th colspan="8">Order Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->getOrderDetails as $detail)
                                        <tr>
                                            <td colspan="8">
                                                <strong>Product Purchased:</strong>&nbsp;
                                                {{ $detail->getProductDetail->name }}
                                                <br/>
                                                <strong>Product Price: </strong>&nbsp;
                                                {{ $detail->price }}
                                                <br/>
                                                <strong>Product Quantity: </strong>&nbsp;
                                                {{ $detail->quantity }}
                                                <br/>
                                                @if($detail->special_discount == 0)
                                                    @if($detail->discount > 0)
                                                        <strong>Discount: </strong>&nbsp;
                                                        {{ $detail->discount }}%<br/>
                                                    @endif
                                                @else
                                                    <strong>Discount: </strong>&nbsp;
                                                    15%
                                                    <br/>
                                                @endif
                                                @if($detail->autoship_discount > 0 && $detail->autoship_interval > 0)
                                                    <strong>Autoship Discount: </strong>&nbsp;
                                                    {{ $detail->autoship_discount }}%
                                                    <br/>
                                                    <strong>Autoship Interval: </strong>&nbsp;
                                                    Ship {{ $autoships[$detail->autoship_interval] }}
                                                @endif
                                                <br/>
                                                @if($detail->subscription_id != NULL)
                                                    <strong>Subscription Id: </strong>&nbsp;
                                                    {{ $detail->subscription_id }}
                                                @endif
                                                <br/>
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
                                        <?php $transactionDetail = $detail->getFirstTransaction() ?>
                                        @if($transactionDetail)
                                            @include('admin/order/_transaction_box', ['transactionDetails' => [$transactionDetail], 'totalTransactions' => 1, 'key' => 0 ])

                                        @else
                                            <tr>
                                                <th>Date</th>
                                                <th>Payment Status</th>
                                                <th>Shipping Status</th>
                                                <th>Shipping Carrier</th>
                                                <th>Shipping Tracking</th>
                                            </tr>
                                            <tr>
                                                <td>{{ Carbon\Carbon::parse($detail->date_time)->format('M d, Y, H:i') }}</td>
                                                <td>
                                                    @if(is_null($detail->error_description))
                                                        {{ $paymentStatus[5] }}
                                                    @else
                                                        {{ $detail->error_description }}
                                                    @endif
                                                </td>
                                                <td>{{ $orderStatus[1] }}</td>
                                                <td></td>
                                                <td>Tracking information is not available. Please add tracking
                                                    information.
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="col-md-12 mt-30">
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <h4>Order Totals</h4>
                                            <table class="table table-condensed data-table">
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
                                        </div>
                                    </div>

                                    @else
                                        <div class="alert alert-warning">
                                            <a href="#" class="close" data-dismiss="alert"></a> No Orders Found
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="text-center">
                                        <a href="{{route('order.index')}}" class="btn btn-info">
                                            Back to all Orderss
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection