@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
<!-- Section: inner-header -->
<div class="main-content">
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title">Your Order's</h2>
        </div>
    </div>

    <section class="divider">
        <div class="container">
            <div class="section-content">
                <div class="row">
                    @if (($orders->count()) > 0)
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered tbl-shopping-cart">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Order Place Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_no }}</td>
                                        <td>{{ $order->first_name . " " . $order->last_name }}</td>
                                        <td>{{ $order->email }}</td>
                                        <td>{{ Carbon\Carbon::parse($order->date_time)->format('Y-m-d H:i') }}</td>
                                        <td>

                                            <a class="btn btn-sm btn-primary btn-block" href="{{ route('order.detail', $order->order_no) }}" data-toggle="tooltip" title="Show">
                                                <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span>Show</span><span class=""> Order Details</span>
                                            </a>
                                            <a class="btn btn-sm btn-primary btn-block" href="{{ route('order.address', $order->order_no) }}" data-toggle="tooltip" title="Update Address">
                                                <i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Update Order Address</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <nav>
                                {{ $orders->links() }}
                            </nav>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert"></a> You have not placed any order yet!
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
