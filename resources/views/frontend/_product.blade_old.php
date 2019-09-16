<div class="container" id="homepage-container">
    <div class="row">
        <?php $count = ""; ?>
        @if(!is_null($homepage_product) && count($homepage_product) > 0)
        @foreach($homepage_product as $product)
        <?php $activeOffers = $product->getActiveOffers(); ?>
        <input id="active-offer" type="hidden" name="active_offers" value="{{ count($product->getActiveOffers()) }}">
        <div class="col-md-4">
            <div class="shop_box_wrap">
                <div class="shop_box">
                    <div class="product-thumb2"> 
                        <a href="{{ route('product', ['slug' => $product->slug]) }}"><img alt="" src="{{ asset('uploads/product/thumbnail/'. $product->getFeaturedImage()->product_image) }}" class="img-responsive img-fullwidth"></a>
                        <div class="overlay"></div>
                    </div>
                    <h2>{{ $product->name }}</h2>
                    <?php
                    $string = NULL;
                    $string = strip_tags($product->product_description);
                    if (strlen($string) > 320) {

                        // truncate string
                        $stringCut = substr($string, 0, 320);

                        // make sure it ends in a word so assassinate doesn't become ass...
                        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . ' ... <a class="read-more" href="' . route('product', ['slug' => $product->slug]) . '">Read More</a>';
                    }
                    ?>
                    <p>{!! html_entity_decode($string) !!}</p>
                    <div class="row" id="apply-height">
                        @if(count($activeOffers) > 0)
                        <?php 
                        $loopCounter = count($activeOffers);
                        if ($loopCounter > 2){
                            $loopCounter = 2;
                        }
                        ?>
                        @for($i = 0; $i < $loopCounter; $i++)
                        <div class="col-sm-{{ $loopCounter > 1 ? '6' : '12'}}">
                            <h3>Save {{ $activeOffers[$i]->offer }}&#37;</h3>
                            <p>Buy {{ $activeOffers[$i]->quantity }} at $<?php echo number_format(round($product->price - ($product->price * $activeOffers[$i]->offer) / 100, 2), 2) ?> per case!</p>
                        </div>
                        @endfor
                        @endif
                    </div>
                    <a href="{{ route('product', ['slug' => $product->slug]) }}" class="btn btn-theme-colored btn-lg mt-30 font-20"><img class="" src="{{ asset('images/dog_icon.png') }}" alt=""> Shop Now</a> 
                </div>
                @if(!is_null($activeOffers) && count($activeOffers) > 2)
                <div class="more_order_overlay">
                    <div><div><a href="{{ route('product', ['slug' => $product->slug]) }}" class="btn btn-primary">View More Offers</a></div></div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".shop_box_wrap").hover(
                function () {
                    $(this).addClass("active");
                },
                function () {
                    $(this).removeClass("active");
                }
        );
        var offer = parseInt($('#active-offer').val());
        if (offer < 2) {
            $('.shop_box .row').addClass('apply-height');
        }
    });
</script>