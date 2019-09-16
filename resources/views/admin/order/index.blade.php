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
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Order List
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if(count($orders) > 0)
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
                                    <a href="#" class="close" data-dismiss="alert"></a> No Order's Found
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Filters
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="GET" action="{{route('order.index')}}">
                            <div class="table-responsive users-table">
                                <table class="table table-striped table-condensed data-table">
                                    <tr>
                                        <th>Order No</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="order" type="text" class="form-control" name="order"
                                                   value="{{ Input::get('order', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>From Date</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id="from" class="form-control datepicker" name="from" value="{{ Input::get('from', '') }}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>To Date</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id="to" class="form-control datepicker" name="to" value="{{ Input::get('to', '') }}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="name" type="text" class="form-control" name="name"
                                                   value="{{ Input::get('name', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Phone No</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="phone" type="text" class="form-control" name="phone"
                                                   value="{{ Input::get('phone', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Company Name</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="company" type="text" class="form-control" name="company"
                                                   value="{{ Input::get('company', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="email" type="email" class="form-control" name="email"
                                                   value="{{ Input::get('email', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Street</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="street" type="text" class="form-control" name="street"
                                                   value="{{ Input::get('street', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Street 2</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="street2" type="text" class="form-control" name="street2"
                                                   value="{{ Input::get('street2', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="city" type="text" class="form-control" name="city"
                                                   value="{{ Input::get('city', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="state" id="state" class="form-control">
                                                <option value="">Please select</option>
                                                @foreach($states as $abr=>$state)
                                                    <option value="{{$abr}}" {{ Input::get('state') == $abr ? 'selected' : ''}} >{{$state}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="country" id="country" class="form-control">
                                                <option value="">Please select</option>
                                                @foreach($countries as $abr => $country)
                                                    <option value="{{$abr}}" {{ Input::get('country') == $abr ? 'selected' : ''}} >{{ $country }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Postal Code</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="postalCode" type="text" class="form-control" name="postal"
                                                   value="{{ Input::get('postal', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="paymentStatus" class="form-control">
                                                <option value="">Please select</option>
                                                @foreach($paymentStatus as $key => $status)
                                                    <option value="{{ $key }}" {{ Input::get('paymentStatus') == $key ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="shippingStatus" class="form-control">
                                                <option value="">Please select</option>
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->id }}" {{ Input::get('shippingStatus') == $status->id ? 'selected' : '' }}>{{ $status->status }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                                <a href="{{route('order.index')}}" class="btn btn-default">
                                    Reset Filters
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".datepicker").datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true
            });
        });
    </script>

@endsection