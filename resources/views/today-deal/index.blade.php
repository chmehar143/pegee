@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-white text-center ">
                <h2 class="title">Today Deals</h2>
            </div>
        </div>

        <section class="divider">
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="products">
                                <div class="row multi-row-clearfix">
                                    @if(!is_null($products) && count($products) > 0)
                                        @foreach($products as $key => $product)
                                            <?php $autoShip = $product->getActiveAutoShip(); ?>
                                            <?php $offerDis = $product->getSaleActiveOffers(); ?>
                                            <?php $maxOffer = $product->getMaxOffer(); ?>
                                            <div class="col-sm-6 col-md-4 col-lg-4 mb-30">
                                                <div class="product">
                                                    @if($product->out_of_stock == 2)
                                                        <span class="tag-out-of-stock"><?php if(empty($product->out_of_stock_message)){ echo "Out of Stock!"; }else { echo $product->out_of_stock_message; } ?></span>
                                                    @else
                                                        <span class="tag-sale">Sale!</span>
                                                    @endif
                                                    <a href="{{ route('product', ['slug' => $product->slug] ) }}">
                                                        <div class="product-thumb"><img alt=""
                                                                                        src="{{ asset('uploads/product/thumbnail/'. $product->getFeaturedImage()->product_image) }}"
                                                                                        class="img-responsive img-fullwidth">
                                                            <div class="overlay"></div>
                                                        </div>
                                                    </a>
                                                    <div class="product-details text-center">
                                                        <a href="{{ route('product', ['slug' => $product->slug] ) }}">
                                                            <h5 class="product-title">{{ $product->name }}</h5></a>
                                                            <div class="star_container {{$product->id}}"></div>
                                                        @if($maxOffer)
                                                            <div class="price">
                                                                <ins>
                                                                    <span class="amount">$<?php echo round($product->price - ($product->price * $maxOffer->offer) / 100, 2) ?></span>
                                                                </ins>
                                                                <del><span class="amount">${{ $product->price }}</span>
                                                                </del>
                                                                <strong class="price-sale">on sale!</strong>
                                                            </div>
                                                        @else
                                                            <div class="price">
                                                                <ins><span class="amount">${{ $product->price }}</span>
                                                                </ins>
                                                            </div>
                                                        @endif
                                                        @if($autoShip)
                                                            <div class="price">
                                                                <span class="autoship_n"><img
                                                                            src="{{ asset('images/ship1.png') }}"
                                                                            width="20" alt="" class="autoship-save"> Autoship & Save an extra 5%</span>
                                                            </div>
                                                        @endif
                                                        <div class="btn-add-to-cart-wrapper">
                                                            <a class="btn btn-default btn-xs btn-add-to-cart"
                                                               href="{{ route('product', ['slug' => $product->slug] ) }}">Add
                                                                To Cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-warning">
                                            <a href="#" class="close" data-dismiss="alert"></a> No Product's Found
                                        </div>
                                    @endif
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <nav>
                                            {{ $products->links() }}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="sidebar sidebar-right mt-sm-30">
                                <div class="widget">
                                    <h5 class="widget-title line-bottom">Search box</h5>
                                    <div class="search-form">
                                        <form method="GET" action="{{ route('deal') }}">
                                            <div class="input-group">
                                                <input name="search" value="{{ Input::get('search', '') }}" type="text"
                                                       placeholder="Click to Search" class="form-control search-input">
                                                <span class="input-group-btn">
                                                <button type="submit" class="btn search-button"><i
                                                            class="fa fa-search"></i></button>
                                            </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="widget">
                                    <h5 class="widget-title line-bottom">Categories</h5>
                                    <div class="categories">
                                        <ul class="list list-border angle-double-right">
                                            @if(!is_null($nav_categories) && count($nav_categories) > 0)
                                                @foreach($nav_categories as $category)
                                                    <li class="red_bg"><a
                                                                href="{{ route('category', ['slug' => $category->slug]) }}">{{ $category->name }}
                                                            <span> ({{ count($category->getActiveProducts()) }}) </span></a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript"> function saLoadScript(src) {
            var js = window.document.createElement('script');
            js.src = src;
            js.type = 'text/javascript';
            document.getElementsByTagName("head")[0].appendChild(js);
        }
        saLoadScript('//www.shopperapproved.com/widgets/group2.0/27575.js'); </script>
@endsection
