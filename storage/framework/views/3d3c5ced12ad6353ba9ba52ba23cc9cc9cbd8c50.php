<?php $__env->startSection('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc')); ?>
<?php $__env->startSection('meta_description', isset($meta_tags) ? $meta_tags->description : ''); ?>
<?php $__env->startSection('content'); ?>
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h2 class="title">Product Detail</h2>
            </div>
        </div>

        <section class="divider">
            <div class="container">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a> <?php echo e(session('success')); ?>

                    </div>
                <?php elseif(session('error')): ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert"
                           aria-label="close">&times;</a> <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>
                <div class="section-content">
                    <div class="row">
                        <div class="product" itemscope itemtype="http://schema.org/Product">
                            <meta itemprop="name" content="<?php echo e($product->name); ?>"/>
                            <meta itemprop="description" content="<?php echo strip_tags($product->product_description); ?>"/>
                            <div class="col-md-4">
                                <div class="product-image">
                                    <?php $offerDis = $product->getActiveOffers(); ?>
                                    <?php $autoShip = $product->getActiveAutoShip(); ?>
                                    <?php if(!is_null($offerDis) && count($offerDis) > 1): ?>
                                        <span class="tag-sale">Sale!</span>
                                    <?php endif; ?>
                                    <ul class="owl-carousel-1col" data-nav="true">
                                        <?php $productImages = $product->getActiveProductImages(); ?>
                                        <?php if(!is_null($productImages) && count($productImages) > 0): ?>
                                            <?php $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li data-thumb="<?php echo e(asset('uploads/product/original/'. $productImage->product_image)); ?>">
                                                    <a rel="prettyPhoto[gallery_name]"
                                                       href="<?php echo e(asset('uploads/product/original/'. $productImage->product_image)); ?>"
                                                       data-lightbox="single-product">
                                                        <img  itemprop="image" src="<?php echo e(asset('uploads/product/original/'. $productImage->product_image)); ?>"
                                                             alt="<?php echo e($product->name); ?>">
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="product-summary">
                                    <h2 class="product-title"><?php echo e($product->name); ?></h2>
                                    <div class="product_reviews" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                        <a href="#review-toggle" id="review-toggle-trigger">
                                            <div id="product_just_stars" class="reg"></div> <script type="text/javascript"> var sa_product = '<?php echo e($product->id); ?>'; (function(w,d,t,f,o,s,a){ o = 'shopperapproved'; if (!w[o]) { w[o] = function() { (w[o].arg = w[o].arg || []).push(arguments) }; s=d.createElement(t), a=d.getElementsByTagName(t)[0];s.async=1;s.src=f;a.parentNode.insertBefore(s,a)} })(window,document,'script','//www.shopperapproved.com/product/27575/'+sa_product+'.js'); </script>
                                        </a>
                                        <ul class="review_text list-inline hide">
                                            <li>
                                                <div title="<?php echo e($product->avg_rating); ?> out of 5">
                                                   <div class="ratingPreview" data-rateyo-rating="<?php echo e($product->avg_rating); ?>"></div>
                                                        <meta itemprop="worstRating" content="1">
                                                        <meta itemprop="bestRating" content="5">
                                                        <meta itemprop="ratingValue" content="<?php echo e($product->avg_rating); ?>">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="price"><strong>Price: </strong>
                                                <ins><span class="amount">&#36;<?php echo e($product->price); ?></span></ins>
                                            </div>
                                            <div class="short-description"></div>
                                            <table class="table table-striped price_save">
                                                <tr>
                                                    <th>Category:</th>
                                                    <td>
                                                        <a href="<?php echo e(route('category', ['slug' => $product->getCategory->slug])); ?>"><?php echo e($product->getCategory->name); ?></a>
                                                    </td>
                                                </tr>
                                                <?php if(!is_null($offerDis) && count($offerDis) > 0): ?>
                                                    <tr>
                                                        <th>Save:</th>
                                                        <td>
                                                            <?php $__currentLoopData = $offerDis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <p>(<?php echo e($offer->offer); ?>&#37;) Buy <?php echo e($offer->quantity); ?>

                                                                    at
                                                                    $<?php echo round($product->price - ($product->price * $offer->offer) / 100, 2) ?>
                                                                    per case!</p>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if($autoShip): ?>
                                                    <tr>
                                                        <th colspan="2">
                                                            <div class="save" title="Auto Ship"><img
                                                                        src="<?php echo e(asset('images/ship1.png')); ?>" alt=""
                                                                        class="autoship-save" width="20"> Autoship &amp;
                                                                Save an
                                                                extra <?php echo e($product->getActiveAutoShip()->autoship_percentage); ?>

                                                                %
                                                            </div>
                                                        </th>
                                                    </tr>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <?php if($product->out_of_stock != 2): ?>
                                                <div class="cart-form-wrapper mt-30">
                                                    <form id="cart-added" enctype="multipart/form-data" method="POST"
                                                          class="cart" action="<?php echo e(route('cart.store')); ?>">
                                                        <?php echo e(csrf_field()); ?>

                                                        <input type="hidden" name="product_slug"
                                                               value="<?php echo e($product->slug); ?>">
                                                        <table class="table variations no-border">
                                                            <tbody>
                                                            <tr>
                                                                <td class="name">Quantity</td>
                                                                <td class="value">
                                                                    <div class="quantity buttons_added">
                                                                        <input type="button" class="minus" value="-">
                                                                        <input type="number" size="4"
                                                                               class="input-text qty text" title="Qty"
                                                                               value="1" name="quantity" min="1" max="5"
                                                                               step="1">
                                                                        <input type="button" class="plus" value="+">
                                                                        <div class="cart-button">
                                                                            <button class="btn btn-theme-colored"
                                                                                    type="submit">Add to cart
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('images/out-of-stock.png')); ?>" alt="Out of Stock"
                                                     width="200">
                                            <?php endif; ?>
                                            <br/>

                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="horizontal-tab product-tab">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
                                        <!--<li><a href="#tab2" data-toggle="tab">Additional Information</a></li>-->
                                        <li><a href="#tab3" id="review-toggle" data-toggle="tab">Reviews</a></li>
                                        <?php if($product->show_video == 1): ?>
                                            <li><a href="#video_tab" data-toggle="tab">Video</a></li>
                                        <?php endif; ?>
                                        <?php if($product->sample_product == 1): ?>
                                            <li><a href="<?php echo e(route('sample.request')); ?>?product=<?php echo e($product->slug); ?>">Get Free Sample</a></li>
                                        <?php endif; ?>
                                        <li><a href="<?php echo e(route('static-page', ['slug' => 'return-policy'])); ?>" target="_blank">Return Policy</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="tab1">
                                            <h3>Product Description</h3>
                                            <p><?php echo html_entity_decode($product->product_description); ?></p>
                                        </div>
                                        <div class="tab-pane fade" id="tab3">
                                            <div class="reviews">
                                                <ol class="commentlist">
                                                    <script type="text/javascript"> var sa_products_count = 5; var sa_date_format = 'F j, Y'; var sa_product = '<?php echo e($product->id); ?>'; (function(w,d,t,f,o,s,a){ o = 'shopperapproved'; if (!w[o]) { w[o] = function() { (w[o].arg = w[o].arg || []).push(arguments) }; s=d.createElement(t), a=d.getElementsByTagName(t)[0];s.async=1;s.src=f;a.parentNode.insertBefore(s,a)} })(window,document,'script','//www.shopperapproved.com/product/27575/'+sa_product+'.js'); </script> <div id="shopper_review_page"><div id="review_header"></div><div id="product_page"></div><div id="review_image"><a href="https://www.shopperapproved.com/reviews/petpads.net/" onclick="var nonwin=navigator.appName!='Microsoft Internet Explorer'?'yes':'no'; var certheight=screen.availHeight-90; window.open(this.href,'shopperapproved','location='+nonwin+',scrollbars=yes,width=620,height='+certheight+',menubar=no,toolbar=no'); return false;" target="_blank" rel="nofollow"></a></div></div>

                                                </ol>
                                            </div>
                                        </div>
                                        <?php if($product->show_video == 1): ?>
                                            <div class="tab-pane fade" id="video_tab">
                                                <h3>Sample Video</h3>
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-6">
                                                        <video class="embed-responsive-item" id="videoContainer"
                                                               preload="auto" controls="controls"
                                                               controlsList="nodownload" poster="" width="100%">
                                                            <source src="<?php echo e(asset('wlmrt.mp4')); ?>" type='video/mp4'>
                                                        </video>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(!is_null($relatedProducts) && count($relatedProducts) > 0): ?>
                            <div class="col-md-12 mt-30">
                                <h4>Related Products</h4>
                                <div class="products related owl-carousel-4col" data-nav="true">
                                    <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $relOffer = $relatedProduct->getSaleActiveOffers(); ?>
                                        <?php $relAutoShip = $relatedProduct->getActiveAutoShip(); ?>
                                        <?php $relOfferDis = $relatedProduct->getActiveOffers(); ?>
                                        <?php $maxOffer = $relatedProduct->getMaxOffer(); ?>
                                        <div class="item">
                                            <div class="product">
                                                <?php if(!is_null($relOfferDis) && count($relOfferDis) > 1): ?>
                                                    <span class="tag-sale">Sale!</span>
                                                <?php endif; ?>
                                                <a href="<?php echo e(route('product', ['slug' => $relatedProduct->slug] )); ?>">
                                                    <div class="product-thumb"><img alt=""
                                                                                    src="<?php echo e(asset('uploads/product/thumbnail/'. $relatedProduct->getFeaturedImage()->product_image)); ?>"
                                                                                    class="img-responsive img-fullwidth">
                                                        <div class="overlay"></div>
                                                    </div>
                                                </a>
                                                <div class="product-details text-center">
                                                    <a href="<?php echo e(route('product', ['slug' => $relatedProduct->slug] )); ?>">
                                                        <h5 class="product-title"><?php echo e($relatedProduct->name); ?></h5></a>
                                                        <div class="star_container <?php echo e($relatedProduct->id); ?>"></div>
                                                    <?php if(!is_null($relOffer) && count($relOffer) > 0): ?>
                                                        <div class="price">
                                                            <ins>
                                                                <span class="amount">$<?php echo round($relatedProduct->price - ($relatedProduct->price * $maxOffer->offer) / 100, 2) ?></span>
                                                            </ins>
                                                            <del>
                                                                <span class="amount">$<?php echo e($relatedProduct->price); ?></span>
                                                            </del>
                                                            <strong class="price-sale">on sale!</strong>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="price">
                                                            <ins>
                                                                <span class="amount">$<?php echo e($relatedProduct->price); ?></span>
                                                            </ins>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($relAutoShip): ?>
                                                        <div class="price">
                                                            <span class="autoship_n"><img
                                                                        src="<?php echo e(asset('images/ship1.png')); ?>" width="20"
                                                                        alt="" class="rel-autoship autoship-save"> Autoship & Save an extra <?php echo e($relatedProduct->getActiveAutoShip()->autoship_percentage); ?>

                                                                % </span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="btn-add-to-cart-wrapper">
                                                        <a class="btn btn-default btn-xs btn-add-to-cart"
                                                           href="<?php echo e(route('product', ['slug' => $relatedProduct->slug] )); ?>">Add
                                                            To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php if(Auth::user()): ?>
        <!-- Modal -->
        <div class="modal fade" id="product-feedback-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="product-feedback-form" name="product_feedback_form" class="login-form"
                          action="<?php echo e(route('feedback.store')); ?>" method="POST">
                        <?php echo e(csrf_field()); ?>

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h5 class="widget-title line-bottom line- font-20">Write Review</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="widget border-1px p-30">

                                        <div class="form-group<?php echo e($errors->has('rating') ? ' has-error' : ''); ?>">
                                            <label class="control-label">Rate this item</label>
                                            <div id="rating">
                                            </div>
                                            <input type='hidden' id="ratingValue" name="rating" value="<?php echo e(old('rating') ? old('rating') : 5); ?>" />

                                            <?php if($errors->has('rating')): ?>
                                                <span class="help-block">
                                            <strong><?php echo e($errors->first('rating')); ?></strong>
                                        </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group<?php echo e($errors->has('subject') ? ' has-error' : ''); ?>">
                                            <input type="text" id="subject" name="subject" class="form-control"
                                                   placeholder="Subject" required="" value="<?php echo e(old('subject')); ?>"/>
                                            <?php if($errors->has('subject')): ?>
                                                <span class="help-block">
                                            <strong><?php echo e($errors->first('subject')); ?></strong>
                                        </span>
                                            <?php endif; ?>
                                        </div>


                                        <div class="form-group<?php echo e($errors->has('product_feedback') ? ' has-error' : ''); ?>">
                                                <textarea rows="10" id="product-feedback" name="product_feedback"
                                                          class="form-control" type="text" placeholder="Write Review"
                                                          required=""><?php echo e(old('product_feedback')); ?></textarea>

                                            <?php if($errors->has('product_feedback')): ?>
                                                <span class="help-block">
                                            <strong><?php echo e($errors->first('product_feedback')); ?></strong>
                                        </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="checkbox form-group">
                                            <label class="control-label">
                                                <input type="checkbox" name="is_anonymous"
                                                       value="1" <?php echo e(old('is_anonymous') == 1 ? 'checked' : ''); ?> />
                                                <span class="text-primary">As Anonymous User</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <input type="hidden" name="product_slug" value="<?php echo e($product->slug); ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-theme-colored">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script type="text/javascript">
        $('#cart-added, #product-feedback-form').submit(function () {
            $(this).find(':input[type=submit]').prop('disabled', true);
        });
        $(document).ready(function () {
            $("#review-toggle-trigger").on('click', function(e){
                e.preventDefault();
                $("#review-toggle").trigger('click');
                $( 'html, body' ).animate({ scrollTop: $('#review-toggle').offset().top }, 1000);
            });
            $("a[rel^='prettyPhoto']").prettyPhoto({
//            theme: 'dark_rounded',
//            theme: 'light_rounded',
                theme: 'facebook',
                slideshow: 3000,
                autoplay_slideshow: false
            });

        });
    </script>
     <script type="text/javascript"> function saLoadScript(src) {
            var js = window.document.createElement('script');
            js.src = src;
            js.type = 'text/javascript';
            document.getElementsByTagName("head")[0].appendChild(js);
        }

        saLoadScript('//www.shopperapproved.com/widgets/group2.0/27575.js'); </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>