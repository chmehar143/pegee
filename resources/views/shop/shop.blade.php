@extends('layouts.app')
@section('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc'))
@section('meta_description', isset($meta_tags) ? $meta_tags->description : '')
@section('content')
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h2 class="title">Shop</h2>
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
                                        @foreach($products as $product)
                                            <?php $offerDis = $product->getSaleActiveOffers(); ?>
                                            <?php $maxOffer = $product->getMaxOffer(); ?>
                                            <?php $autoShip = $product->getActiveAutoShip(); ?>
                                            <?php $offerDiscount = $product->getActiveOffers(); ?>
                                            <div class="col-sm-6 col-md-4 col-lg-4 mb-30">
                                                <div class="product">
                                                    @if($product->out_of_stock == 2)
                                                        <span class="tag-out-of-stock"><?php if(empty($product->out_of_stock_message)){ echo "Out of Stock!"; }else { echo $product->out_of_stock_message; } ?></span>
                                                    @else
                                                        @if(!is_null($offerDiscount) && count($offerDiscount) > 1)
                                                            <span class="tag-sale">Sale!</span>
                                                        @endif
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
                                                                            width="20" alt="" class="autoship-save"> Autoship & Save an extra {{ $product->getActiveAutoShip()->autoship_percentage }}
                                                                    % </span>
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
                                        <form method="GET" action="{{ route('shop') }}">
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
                                        {!! getCategoriesFrontView($nav_categories,"") !!}
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Train Your Pet Right with Our Dog Training Pads</h3>
                            <p>Training your dog how to potty can be a challenge. You need to be able to easily train
                                them where and when to go. Of course, training your pet to use dog training pads is very
                                useful, especially for residents of New York, New Jersey that lead a busy lifestyle.
                                Having one place to contain the mess is a great option when it comes to using puppy
                                pads. At PetsWorld, Inc. we offer a wide variety of training pads that range from
                                extra-large dog training pads with maximum hold, ultra-hold and even premium adhesive
                                tapes training pads. Whether you need extra-large puppy pads or extra-large wee wee
                                pads, we have the pads you’re looking for all at excellent prices.</p>
                            <h3>Easily Order Disposable Dog Pads Online from Us</h3>
                            <p>At PetsWorld, Inc. we do everything we can to make it simple to order dog training pads
                                from us online. We promise you will receive your order fast and easy. We will deliver
                                them to your door and even offer auto shipment for standing orders to you don’t have to
                                worry about remembering to order them at all! Not only can you shop from our variety of
                                puppy pad options, we’ll also send your order to you absolutely free no matter the size.
                                Our pet pads are perfect for pet owners, veterinary professionals and pet organizations.
                                When you want only the highest of quality when it comes to dog pads, we sell the best on
                                the market. You’ll benefit from our heavy absorbency, heavily discounted prices and
                                extra-large professional training pad sizes. Order in bulk quantities today!</p>
                            <h3>Different Types of Training Pads We Offer Includes:</h3>

                            <ul class="list-pads-disc">
                                <li>Training & Potty Pads 30x36</li>
                                <li>Training & Potty Pads 28x34</li>
                                <li>Training & Potty Pads 30x30</li>
                                <li>Training & Potty Pads 23x36</li>
                                <li>Training & Potty Pads 24x24</li>
                                <li>Training & Potty Pads 17x24</li>
                            </ul>
                            <h3>Contact Us</h3>
                            <p><a href="{{ route('static-page', ['slug' => 'contact-us'])}}">Contact us</a> to place
                                your order for dog training pads today. We are more than happy to assist you in any
                                manner you require. </p>
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
