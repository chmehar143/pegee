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
                        Offer Detail
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if(count($offer) > 0)
                        <table class="table table-striped table-condensed data-table">
                            <tr>
                                <th>{{ "Product Name" }}</th>
                                <td>{{ $offer->getProduct->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ "Product Picture" }}</th>
                                <td><img class="img-responsive img-thumbnail" src="{{ asset('uploads/product/thumbnail/'. $offer->getProduct->getFeaturedImage()->product_image) }}" alt="{{$offer->getProduct->slug}}"></td>
                            </tr>
                            <tr>
                                <th>{{ "Discount Percent" }}</th>
                                <td>{{ $offer->offer }} &#37;</td>
                            </tr>
                            <tr>
                                <th>{{ "Discount on Product Quantity" }}</th>
                                <td>{{ $offer->quantity }}</td>
                            </tr>
                            <tr>
                                <th>{{ "Offer Status" }}</th>
                                <td>{{ $offer->offer_status == 1 ? "Active" : "Deactivated" }}</td>
                            </tr>
                        </table>

                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Offer's Found
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <a href="{{route('offer.index')}}" class="btn btn-info">
                                Back to all offer's
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection