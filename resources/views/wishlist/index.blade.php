@extends('layouts.app')

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
                        Your Shopping Cart
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if (sizeof(Cart::instance('wishlist')->content()) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::instance('wishlist')->content() as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>&#36;{{ $item->price * $item->qty }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-warning btn-block" href="{{ route('wishlist.destroy', $item->rowId) }}" onclick="
                                                event.preventDefault();
                                                document.getElementById('wishlist.destroy-<?php echo $item->rowId ?>').submit();" data-toggle="tooltip" title="Remove">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="">Remove</span><span class=""> Product</span>
                                        </a>
                                        <form id="wishlist.destroy-{{$item->rowId}}" action="{{ route('wishlist.destroy', $item->rowId) }}" method="POST" style="display: none;" onsubmit="return confirm('Are You Sure')">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('switch.cart', $item->rowId) }}" onclick="
                                                event.preventDefault();
                                                document.getElementById('switch.cart-<?php echo $item->rowId ?>').submit();" data-toggle="tooltip" title="Delete">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="">Move To</span><span class=""> Cart</span>
                                        </a>
                                        <form id="switch.cart-{{$item->rowId}}" action="{{ route('switch.cart', $item->rowId) }}" method="POST" style="display: none;" onsubmit="return confirm('Are You Sure')">
                                            {{ csrf_field() }}
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right">
                            <form action="{{ route('empty.wishlist') }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <input type="submit" class="btn btn-danger" value="Clear Wishlist">
                            </form>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> Your Wishlist is Empty
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
