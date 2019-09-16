<?php $__env->startSection('title', isset($meta_tags) ? $meta_tags->title : "Reviews - " . config('app.name', 'PetsWorld, Inc')); ?>
<?php $__env->startSection('meta_description', isset($meta_tags) ? $meta_tags->description : ''); ?>
<?php $__env->startSection('content'); ?>
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h2 class="title">Reviews</h2>
            </div>
        </div>

        <section id="about">
            <div class="container pb-80">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">
                            <script type="text/javascript"> var sa_review_count = 20; var sa_date_format = 'F j, Y'; function saLoadScript(src) { var js = window.document.createElement("script"); js.src = src; js.type = "text/javascript"; document.getElementsByTagName("head")[0].appendChild(js); } saLoadScript('//www.shopperapproved.com/merchant/27575.js'); </script><div id="shopper_review_page"><div id="review_header"></div><div id="merchant_page"></div><div id="review_image"><a href="https://www.shopperapproved.com/reviews/petpads.net/" target="_blank" rel="nofollow"></a></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>