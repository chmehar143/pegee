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
                            Pending Order List ({{$orders->count()}})
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if($orders->count() > 0)
                                <table class="table table-striped table-condensed data-table">
                                    <thead>
                                    <tr>
                                        <th>Order no</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th width="100">Order Date</th>
                                        <th>Payment & Shipping Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_no }}</td>
                                            <td>{{ $order->first_name . " " . $order->last_name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ Carbon\Carbon::parse($order->date_time)->format('M d, Y, H:i') }}</td>
                                            <?php $orderDetails = $order->getOrderDetails; ?>
                                            <td>
                                                @foreach($orderDetails as $key => $orderDetail)
                                                    <p><strong>Product
                                                            Name:</strong> {{$orderDetail->getProductDetail->name}}</p>
                                                    <p><strong>Product Quantity:</strong> {{$orderDetail->quantity}}</p>
                                                    <?php $recentTransaction = $orderDetail->getRecentTransactionDetail(); ?>
                                                    <p><strong>Payment Status:</strong>
                                                        @if($recentTransaction)
                                                            {{ $paymentStatus[$recentTransaction->payment_status] }}
                                                        @else
                                                            @if(is_null($orderDetail->error_description))
                                                                {{ $paymentStatus[5] }}
                                                            @else
                                                                {{ $orderDetail->error_description }}
                                                            @endif
                                                        @endif

                                                    </p>
                                                    <p><strong>Shipping Status:</strong>
                                                        @if($recentTransaction)
                                                            {{ $orderStatus[$recentTransaction->shipping_status] }}
                                                        @else
                                                            {{ $orderStatus[1] }}
                                                        @endif
                                                    </p>
                                                    @if($orderDetail->subscription_id != NULL)
                                                        <p><strong>Subscription
                                                                Id: </strong>&nbsp;{{ $orderDetail->subscription_id }}
                                                        </p>
                                                    @endif

                                                    @if($orderDetail->autoship_discount > 0 && $orderDetail->autoship_interval > 0)
                                                        <p>
                                                            <strong>Autoship Discount: </strong>&nbsp;
                                                            {{ $orderDetail->autoship_discount }}%
                                                        </p>
                                                        <p>
                                                            <strong>Autoship Interval: </strong>&nbsp;
                                                            Ship {{ $autoships[$orderDetail->autoship_interval] }}
                                                        </p>
                                                    @endif
                                                    @if($orderDetail->subscription_status > 0)
                                                        <p>
                                                            <strong>Subscription Status: </strong>&nbsp;
                                                            @if($orderDetail->subscription_status == 1)
                                                                <span class="label label-success">{{ $subscriptionStatus[$orderDetail->subscription_status] }}</span>
                                                            @elseif($orderDetail->subscription_status == 2)
                                                                <span class="label label-danger">{{ $subscriptionStatus[$orderDetail->subscription_status] }}</span>
                                                            @endif
                                                        </p>
                                                    @endif


                                                    @if($key +1 != count($orderDetails))
                                                        <hr/>
                                                    @endif

                                                @endforeach
                                            </td>
                                            <td width="20">
                                                <a class="btn btn-sm btn-primary btn-block"
                                                   href="{{ route('order.show', $order->id) }}" data-toggle="tooltip"
                                                   title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span>Show</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Pending Orders
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection