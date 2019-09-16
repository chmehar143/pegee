
    <div class="row">
        <div class="products">
            <div class="multi-row-clearfix">
                @if(!is_null($homepage_product) && count($homepage_product) > 0)
                @foreach($homepage_product as $key => $product)
                <?php $autoShip = $product->getActiveAutoShip(); ?>
                <?php $offerDis = $product->getSaleActiveOffers(); ?>
                <?php $maxOffer = $product->getMaxOffer(); ?>
                <div class="col-sm-5 col-md-3 col-lg-3 mb-30">
                    <div class="product">
                        <span class="tag-sale">Sale!</span>       
                        <a href="{{ route('product', ['slug' => $product->slug] ) }}">
                            <div class="product-thumb">
                                @if($product->getFeaturedImage())
                                <img alt="" src="{{ asset('uploads/product/thumbnail/'. $product->getFeaturedImage()->product_image) }}" class="img-responsive img-fullwidth">
                                @endif
                                <div class="overlay"></div>
                            </div>
                        </a>
                        <div class="product-details text-center">
                            <a href="{{ route('product', ['slug' => $product->slug] ) }}"><h5 class="product-title">{{ $product->name }}</h5></a>
                            <div class="star_container {{$product->id}}"></div>
                            @if($maxOffer)
                            <div class="price">
                                <ins><span class="amount">$<?php echo round($product->price - ($product->price * $maxOffer->offer) / 100, 2) ?></span></ins>
                                <del><span class="amount">${{ $product->price }}</span></del>
                                <strong class="price-sale">on sale!</strong>
                            </div>
                            @else
                            <div class="price">
                                <ins><span class="amount">${{ $product->price }}</span></ins>
                            </div>
                            @endif
                            @if($autoShip)
                            <div class="price">
                                <span class="autoship_n"><img src="{{ asset('images/ship1.png') }}" width="20" alt="" class="autoship-save"> Autoship & Save an extra 5%</span>
                            </div>
                            @else
                            <div class="custom-heigt">
                                <!--<span class="autoship_n"><img src="{{ asset('images/ship1.png') }}" width="20" alt="" class="autoship-save"> Autoship & Save an extra 5%</span>-->
                            </div>
                            @endif
                            <div class="short-description">
                                <span>{!! html_entity_decode($product->short_description) !!}</span>
                            </div>
                            <div class="btn-add-to-cart-wrapper">
                                <a class="btn btn-default btn-xs btn-add-to-cart" href="{{ route('product', ['slug' => $product->slug] ) }}">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
