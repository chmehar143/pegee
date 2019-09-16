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
                            Subscription Details for Order # {{$order->order_no}} and Product
                            : {{$detail->getProductDetail->name}}
                        </div>
                    </div>

                    <div class="panel-body">
                        @include('admin/order/_order_detail_box', ['detail' => $detail, 'showFirstOnly' => false, 'hideViewSubscriptionButton' => true])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection