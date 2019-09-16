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
                        Offers List
                        <a class="btn btn-default" href="{{ route('offer.create') }}" data-toggle="tooltip" title="Create">
                            <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span class=""> Offer</span>
                        </a>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($offers) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Discount Percent</th>
                                    <th>Discount Quantity</th>
                                    <th>Offer Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offers as $offer)
                                <tr>
                                    <td>{{ $offer->getProduct->name  }}</td>
                                    <td>{{ $offer->offer }} &#37;</td>
                                    <td>{{ $offer->quantity }}</td>
                                    <td>{{ $statuses[$offer->offer_status] }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-primary btn-block" href="{{ route('offer.show', $offer->id) }}" data-toggle="tooltip" title="Show">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span>Show</span><span class=""> Offer</span>
                                        </a>
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('offer.edit', $offer->id) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span>Edit</span><span class=""> Offer</span>
                                        </a>
                                    @if($offer->offer_status != 1)
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-info btn-block" href="{{ route('offer.activate', $offer->id) }}" data-toggle="tooltip" title="Activate">
                                            <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span class="">Activate</span></span>
                                        </a>
                                    @else
                                        <a onclick="return confirm('Are you sure')" class="btn btn-sm btn-warning btn-block" href="{{ route('offer.deactivate', $offer->id) }}" data-toggle="tooltip" title="Deactivate">
                                            <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span class="">Deactivate</span>
                                        </a>
                                    @endif
<!--                                        <a class="btn btn-sm btn-danger btn-block {{ $offer->offer_status == 2 ? ' disabled' : '' }}" href="{{ route('offer.destroy', $offer->id) }}" onclick="
                                                event.preventDefault();
                                                document.getElementById('destroy-form-<?php //echo $offer->id ?>').submit();" data-toggle="tooltip" title="Remove">
                                            <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Remove</span><span class=""> Offer</span>
                                        </a>
                                        <form id="destroy-form-{{$offer->id}}" action="{{ route('offer.destroy', $offer->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Are you sure')">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                        </form>-->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Offers Found
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {{ $offers->links() }}
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
                    <form class="form-horizontal" method="GET" action="{{route('offer.index')}}">
                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <tr>
                                    <th>Product Name</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="product" id="product-id" class="form-control" >
                                            <option value="">Please select</option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}" {{ Input::get('product') == $product->id ? 'selected' : '' }} >{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Discount &#37;</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="offer" type="text" class="form-control" name="offer" value="{{ Input::get('offer', '') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Discount Quantity</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="quantity" type="text" class="form-control" name="quantity" value="{{ Input::get('quantity', '') }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Offer Status</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="status" class="form-control">
                                            <option value="" >Please select</option>
                                            @foreach($statuses as $key => $status)
                                            <option value="{{ $key }}" {{ Input::get('status') == $key ? 'selected' : '' }}>{{ $status }}</option>
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
                            <a href="{{route('offer.index')}}" class="btn btn-default">
                                Reset Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection