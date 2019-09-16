
    <div class="row">
        <div class="products">
            <div class="multi-row-clearfix">
                <?php if(!is_null($homepage_product) && count($homepage_product) > 0): ?>
                <?php $__currentLoopData = $homepage_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $autoShip = $product->getActiveAutoShip(); ?>
                <?php $offerDis = $product->getSaleActiveOffers(); ?>
                <?php $maxOffer = $product->getMaxOffer(); ?>
                <div class="col-sm-5 col-md-3 col-lg-3 mb-30">
                    <div class="product">
                        <span class="tag-sale">Sale!</span>       
                        <a href="<?php echo e(route('product', ['slug' => $product->slug] )); ?>">
                            <div class="product-thumb">
                                <?php if($product->getFeaturedImage()): ?>
                                <img alt="" src="<?php echo e(asset('uploads/product/thumbnail/'. $product->getFeaturedImage()->product_image)); ?>" class="img-responsive img-fullwidth">
                                <?php endif; ?>
                                <div class="overlay"></div>
                            </div>
                        </a>
                        <div class="product-details text-center">
                            <a href="<?php echo e(route('product', ['slug' => $product->slug] )); ?>"><h5 class="product-title"><?php echo e($product->name); ?></h5></a>
                            <div class="star_container <?php echo e($product->id); ?>"></div>
                            <?php if($maxOffer): ?>
                            <div class="price">
                                <ins><span class="amount">$<?php echo round($product->price - ($product->price * $maxOffer->offer) / 100, 2) ?></span></ins>
                                <del><span class="amount">$<?php echo e($product->price); ?></span></del>
                                <strong class="price-sale">on sale!</strong>
                            </div>
                            <?php else: ?>
                            <div class="price">
                                <ins><span class="amount">$<?php echo e($product->price); ?></span></ins>
                            </div>
                            <?php endif; ?>
                            <?php if($autoShip): ?>
                            <div class="price">
                                <span class="autoship_n"><img src="<?php echo e(asset('images/ship1.png')); ?>" width="20" alt="" class="autoship-save"> Autoship & Save an extra 5%</span>
                            </div>
                            <?php else: ?>
                            <div class="custom-heigt">
                                <!--<span class="autoship_n"><img src="<?php echo e(asset('images/ship1.png')); ?>" width="20" alt="" class="autoship-save"> Autoship & Save an extra 5%</span>-->
                            </div>
                            <?php endif; ?>
                            <div class="short-description">
                                <span><?php echo html_entity_decode($product->short_description); ?></span>
                            </div>
                            <div class="btn-add-to-cart-wrapper">
                                <a class="btn btn-default btn-xs btn-add-to-cart" href="<?php echo e(route('product', ['slug' => $product->slug] )); ?>">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
