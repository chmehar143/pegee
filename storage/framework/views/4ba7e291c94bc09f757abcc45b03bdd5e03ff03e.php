<?php $__env->startSection('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc')); ?>
<?php $__env->startSection('meta_description', isset($meta_tags) ? $meta_tags->description : ''); ?>
<?php $__env->startSection('content'); ?>
    <div class="main_title chart_bg">
        <div class="container text-center">
            <h2 class="title"><?php echo e($category->name); ?></h2>
        </div>
    </div>

    <section class="divider">
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-9">
                    <div class="breadcrumb">
                        <?php echo getShopBreadCrumb($category); ?>

                    </div>
                        <div class="products">
                            <div class="row multi-row-clearfix">
                                <?php if(count($products) > 0): ?>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $maxOffer = $product->getMaxOffer(); ?>
                                        <?php $autoShip = $product->getActiveAutoShip(); ?>
                                        <div class="col-sm-6 col-md-4 col-lg-4 mb-30">
                                            <div class="product">
                                                <?php if($product->out_of_stock == 2): ?>
                                                    <span class="tag-out-of-stock"><?php if(empty($product->out_of_stock_message)){ echo "Out of Stock!"; }else { echo $product->out_of_stock_message; } ?></span>
                                                <?php else: ?>
                                                    <?php if(!is_null(count($product->getActiveOffers())) && count($product->getActiveOffers()) > 1): ?>
                                                        <span class="tag-sale">Sale!</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <a href="<?php echo e(route('product', ['slug' => $product->slug] )); ?>">
                                                    <div class="product-thumb"><img alt=""
                                                                                    src="<?php echo e(asset('uploads/product/thumbnail/'. $product->getFeaturedImage()->product_image)); ?>"
                                                                                    class="img-responsive img-fullwidth">
                                                        <div class="overlay"></div>
                                                    </div>
                                                </a>
                                                <div class="product-details text-center">
                                                    <a href="<?php echo e(route('product', ['slug' => $product->slug] )); ?>"><h5
                                                                class="product-title"><?php echo e($product->name); ?></h5></a>
                                                    <div class="star_container <?php echo e($product->id); ?>"></div>
                                                    <?php if($maxOffer): ?>
                                                        <div class="price">
                                                            <ins>
                                                                <span class="amount">$<?php echo round($product->price - ($product->price * $maxOffer->offer) / 100, 2) ?></span>
                                                            </ins>
                                                            <del><span class="amount">$<?php echo e($product->price); ?></span>
                                                            </del>
                                                            <strong class="price-sale">on sale!</strong>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="price">
                                                            <ins><span class="amount">$<?php echo e($product->price); ?></span>
                                                            </ins>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($autoShip): ?>
                                                        <div class="price">
                                                            <span class="autoship_n"><img
                                                                        src="<?php echo e(asset('images/ship1.png')); ?>" width="20"
                                                                        alt="" class="autoship-save"> Autoship & Save an extra 5%</span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="btn-add-to-cart-wrapper">
                                                        <a class="btn btn-default btn-xs btn-add-to-cart"
                                                           href="<?php echo e(route('product', ['slug' => $product->slug] )); ?>">Add
                                                            To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        <a href="#" class="close" data-dismiss="alert"></a> No Products Found
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sidebar sidebar-right mt-sm-30">
                            <div class="widget">
                                <h5 class="widget-title line-bottom">Categories</h5>
                                <div class="categories">
                                    <ul class="list list-border angle-double-right" >
                                        <?php echo getCategoriesFrontView($category->childrenCategory()->oldest('weight')->get(),""); ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="chart_bg">
        <div class="container pt-0 pb-30">
            <div class="row">
                <div class="call-to-action pt-30 pb-20">
                    <div class="col-md-9">
                        <h3 class="mt-5">Not sure which PAD is right for your dog? </h3>
                    </div>
                    <div class="col-md-3 text-right flip sm-text-center">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-window-choose"
                           class="btn btn-theme-colored btn-circled btn-lg font-20">See Our Chart <i
                                    class="fa fa-share ml-10" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php echo $__env->make('sample._size_chart_model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script type="text/javascript"> function saLoadScript(src) {
            var js = window.document.createElement('script');
            js.src = src;
            js.type = 'text/javascript';
            document.getElementsByTagName("head")[0].appendChild(js);
        }

        saLoadScript('//www.shopperapproved.com/widgets/group2.0/27575.js'); </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>