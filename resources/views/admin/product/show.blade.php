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
                        Product Detail
                    </div>
                </div>

                <div class="panel-body">

                    <div class="table-responsive users-table">
                        @if($product)
                        <table class="table table-striped table-condensed data-table">
                            <tr>
                                <th>Product Name</th>
                                <td>{{ $product->name}}</td>
                            </tr>
                            <tr>
                                <th>Product Price</th>
                                <td>{{ $product->price}}</td>
                            </tr>
                            <tr>
                                <th>Product Image</th>
                                <td><img class="img-responsive img-thumbnail" src="{{ asset('uploads/product/thumbnail/'. $product->getFeaturedImage()->product_image) }}" alt="{{$product->slug}}"></td>
                            </tr>
                            <tr>
                                <th>Product Description</th>
                                <td>{{ strip_tags($product->product_description) }}</td>
                            </tr>
                            <tr>
                                <th>Product Code</th>
                                <td>{{ $product->product_code}}</td>
                            </tr>
                            <tr>
                                <th>Product Status</th>
                                <td>{{ $product->product_status == 1 ? "Active" : "Deactivated" }}</td>
                            </tr>
                            <tr>
                                <th>Product Category</th>
                                <td>{{ $product->getCategory->name }}</td>
                            </tr>
                        </table>

                        @else
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert"></a> No Product's Found
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <a href="{{route('product.index')}}" class="btn btn-info">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection