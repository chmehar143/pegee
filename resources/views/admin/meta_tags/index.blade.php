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
                            Meta Tags
                            <div>
                                <a class="btn btn-default" href="{{ route('meta_tags.create') }}" data-toggle="tooltip"
                                   title="Create">
                                    <i class="fa fa-plus-square fa-fw" aria-hidden="true"></i> <span>Create</span></a>

                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive users-table">
                            @if(count($meta_tags) > 0)
                                <table class="table table-striped table-condensed data-table">
                                    <thead>
                                    <tr>
                                        <th width="70">Sr. No.</th>
                                        <th>Page Name</th>
                                        <th width="250">Title</th>
                                        <th width="300">Meta Description</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($meta_tags as $key => $meta_tag)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $meta_tag->getName() }}</td>
                                            <td>{{ $meta_tag->title }}</td>
                                            <td>{{ $meta_tag->description }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary btn-block"
                                                   href="{{ route('meta_tags.show', $meta_tag->id) }}"
                                                   data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span>Show</span>
                                                </a>
                                                <a class="btn btn-sm btn-success btn-block"
                                                   href="{{ route('meta_tags.edit', $meta_tag->id) }}"
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                                    <span>Edit</span>
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert"></a> No Meta Tags Found
                                </div>
                            @endif
                            <div class="text-center">
                                {{ $meta_tags->links() }}
                            </div>
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
                        <form class="form-horizontal" method="GET" action="{{route('meta_tags.index')}}">
                            <div class="table-responsive users-table">
                                <table class="table table-striped table-condensed data-table">
                                    <tr>
                                        <th>Page Name</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select id="resource_id" name="resourceId" class="form-control">
                                                <option value="">Please Select</option>
                                                <option value="1"
                                                        data-type="home-page" {{Input::get('resourceType', '') == 'home-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - Home
                                                </option>
                                                <option value="1"
                                                        data-type="shop-page" {{Input::get('resourceType', '') == 'shop-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - Shop
                                                </option>
                                                <option value="1"
                                                        data-type="deals-page" {{Input::get('resourceType', '') == 'deals-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - Today Deals
                                                </option>
                                                <option value="1"
                                                        data-type="sample-page" {{Input::get('resourceType', '') == 'sample-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - Free Sample Request
                                                </option>
                                                <option value="1"
                                                        data-type="track-page" {{Input::get('resourceType', '') == 'track-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - Track Order
                                                </option>
                                                <option value="1"
                                                        data-type="view-cart-page" {{Input::get('resourceType', '') == 'view-cart-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - Your Cart
                                                </option>
                                                <option value="1"
                                                        data-type="checkout-page" {{Input::get('resourceType', '') == 'checkout-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - Checkout
                                                </option>
                                                <option value="1"
                                                        data-type="my-orders-page" {{Input::get('resourceType', '') == 'my-orders-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - My Orders
                                                </option>
                                                <option value="1"
                                                        data-type="order-detail-page" {{Input::get('resourceType', '') == 'order-detail-page' && Input::get('resourceId', '') == 1 ? 'selected' : ''}}>
                                                    Pages - Order Details Page
                                                </option>

                                                <option value="1"
                                                        data-type="blog_post-page" {{old('resourceType') == 'blog_post-page' && old('resourceId') == 1 ? 'selected' : ''}}>
                                                    Pages - Blog
                                                </option>
                                                @foreach($static_pages as $static_page)
                                                    <option value="{{$static_page->id}}"
                                                            data-type="static-page" {{Input::get('resourceType', '') == 'static-page' && Input::get('resourceId', '') == $static_page->id ? 'selected' : '' }}>
                                                        Pages
                                                        - {{$static_page->page_name}}</option>
                                                @endforeach
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}"
                                                            data-type="category" {{Input::get('resourceType', '') == 'category' && Input::get('resourceId', '') == $category->id ? 'selected' : ''}}>
                                                        Category
                                                        - {{$category->name}}</option>
                                                @endforeach
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}"
                                                            data-type="product" {{Input::get('resourceType', '') == 'product' && Input::get('resourceId', '') == $product->id ? 'selected' : ''}}>
                                                        Product- {{$product->name}}</option>
                                                @endforeach
                                                @foreach($blog_posts as $blog_post)
                                                    <option value="{{$blog_post->id}}"
                                                            data-type="blog_post" {{Input::get('resourceType', '') == 'blog_post' && Input::get('resourceId', '') == $blog_post->id ? 'selected' : ''}}>
                                                        Blog Post- {{$blog_post->name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="resource_type" name="resourceType"
                                                   value="{{ Input::get('resourceType', '') }}"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="title" type="text" class="form-control" name="title"
                                                   value="{{ Input::get('title', '') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="description" type="text" class="form-control" name="description"
                                                   value="{{ Input::get('description', '') }}">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Search
                                </button>
                                <a href="{{route('meta_tags.index')}}" class="btn btn-default">
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
        $(document).ready(function () {
            $("#resource_id").on('change', function () {
                var selected = $(this).find('option:selected');
                $("#resource_type").val(selected.data('type'));
            });
        });
    </script>

@endsection