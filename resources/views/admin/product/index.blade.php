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
        @include('admin/product/_filters')

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Products
                            <div>
                                <a class="btn btn-default" href="{{ route('product.create') }}" data-toggle="tooltip"
                                   title="Create">
                                    <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span><span
                                            class=""> Product</span>
                                </a>
                                <a class="btn btn-default" href="{{ route('import.form') }}" data-toggle="tooltip"
                                   title="Import">
                                    <i class="fa fa-download fa-fw" aria-hidden="true"></i> <span>Import</span><span
                                            class=""> CSV</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            @if(count($products) > 0)
                                <table class="table table-striped table-condensed data-table">
                                    <thead>
                                    <tr>
                                        <td></td>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th>Weight</th>
                                        <th>Display on Homepage</th>
                                        <th>Sample Request</th>
                                        <th>Show Video</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td width="100">
                                                @if($product->getFeaturedImage())
                                                <img alt=""
                                                     src="{{ asset('uploads/product/thumbnail/'. $product->getFeaturedImage()->product_image) }}"
                                                     class="img-responsive img-fullwidth">
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->product_quantity }}</td>
                                            <td>{{ $product->product_code }}</td>
                                            <td>{{ $statuses[$product->product_status] }}</td>
                                            <td>{{ $product->weight }}</td>
                                            <td align="center"><?php echo $product->product_featured == 1 ? "<i  class='fa fa-check fa-fw'></i>" : "<i  class='fa fa-times fa-fw'></i>" ?></td>
                                            <td align="center"><?php echo $product->sample_product == 1 ? "<i  class='fa fa-check fa-fw'></i>" : "<i  class='fa fa-times fa-fw'></i>" ?></td>
                                            <td align="center"><?php echo $product->show_video == 1 ? "<i  class='fa fa-check fa-fw'></i>" : "<i  class='fa fa-times fa-fw'></i>" ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-primary btn-block"
                                                   href="{{ route('product.show', $product->id) }}"
                                                   data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span>View</span>
                                                </a>
                                                <a class="btn btn-sm btn-success btn-block"
                                                   href="{{ route('product.edit', $product->id) }}"
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="btn btn-sm btn-success btn-block"
                                                   href="{{ route('meta_tags.create', ['resource_id' => $product->id, 'resource_type' => 'product']) }}"
                                                   data-toggle="tooltip" title="MetaTags">
                                                    <i class="fa fa-info fa-fw" aria-hidden="true"></i>
                                                    <span>Meta Tags</span>
                                                </a>
                                                @if($product->out_of_stock != 2)
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-default btn-block"
                                                       href="{{ route('product.outstock', $product->id) }}"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-thumbs-down fa-fw" aria-hidden="true"></i> <span
                                                                class="">Out of Stock</span></span>
                                                    </a>
                                                @else
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-default btn-block"
                                                       href="{{ route('product.instock', $product->id) }}"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-thumbs-up fa-fw" aria-hidden="true"></i> <span
                                                                class="">In Stock</span></span>
                                                    </a>
                                                @endif
                                                @if($product->sample_product != 2)
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-default btn-block"
                                                       href="{{ route('product.dssample', $product->id) }}"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-thumbs-down fa-fw" aria-hidden="true"></i> <span
                                                                class="">Disable Sample Request</span></span>
                                                    </a>
                                                @else
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-default btn-block"
                                                       href="{{ route('product.ensample', $product->id) }}"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-thumbs-up fa-fw" aria-hidden="true"></i> <span
                                                                class="">Enable Sample Request</span>
                                                    </a>
                                                @endif
                                                @if($product->show_video != 2)
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-info btn-block"
                                                       href="{{ route('product.dsvideo', $product->id) }}"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-video-camera fa-fw" aria-hidden="true"></i>
                                                        <span class="">Deactivate Video</span></span>
                                                    </a>
                                                @else
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-info btn-block"
                                                       href="{{ route('product.acvideo', $product->id) }}"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-video-camera fa-fw" aria-hidden="true"></i>
                                                        <span class="">Activate Video</span></span>
                                                    </a>
                                                @endif
                                                @if($product->product_status != 1)
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-info btn-block"
                                                       href="{{ route('product.activate', $product->id) }}"
                                                       data-toggle="tooltip" title="Activate">
                                                        <i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i> <span
                                                                class="">Activate</span></span>
                                                    </a>
                                                @else
                                                    <a onclick="return confirm('Are you sure')"
                                                       class="btn btn-sm btn-warning btn-block"
                                                       href="{{ route('product.deactivate', $product->id) }}"
                                                       data-toggle="tooltip" title="Deactivate">
                                                        <i class="fa fa-ban fa-fw" aria-hidden="true"></i> <span
                                                                class="">Deactivate</span></span>
                                                    </a>
                                                @endif
                                                <a class="btn btn-sm btn-danger btn-block {{ $product->product_status == 2 ? ' disabled' : '' }}"
                                                   href="{{ route('product.destroy', $product->id) }}" onclick="
                                                        event.preventDefault();
                                                        document.getElementById('destroy-form-<?php echo $product->id ?>').submit();"
                                                   data-toggle="tooltip" title="Remove">
                                                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i> <span class="">Remove</span>
                                                </a>
                                                <form id="destroy-form-{{$product->id}}"
                                                      action="{{ route('product.destroy', $product->id) }}"
                                                      method="POST" style="display: none;"
                                                      onsubmit="return confirm('Are you sure')">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Products Found
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection