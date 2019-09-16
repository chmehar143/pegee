<?php $__env->startSection('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc')); ?>
<?php $__env->startSection('meta_description', isset($meta_tags) ? $meta_tags->description : ''); ?>

<?php $__env->startSection('content'); ?>
    <!-- Start Section: home -->
    <section id="home">
        <div class="container-fluid p-0">
            <?php echo $__env->make('frontend/_slider', ['home_sliders' => $home_sliders], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </section>
    <!-- End Section: home -->
    <section class="shop_wrap">
        <div class="container" id="homepage-container">
            <div class="row">
					<div class="col-lg-4 col-md-6 col-sm-12">	
						<a href="#">
							<div class="single_promo">
								<img src="<?php echo e(asset('images/abc/1.jpg')); ?>" alt="">
								
							</div>
						</a>						
					</div><!--  End Col -->						
					
					<div class="col-lg-4 col-md-6 col-sm-12">	
						<a href="#">
							<div class="single_promo">
								<img src="<?php echo e(asset('images/cba/1.jpg')); ?>" alt="">
                                <div class="m-3" style="margin-top:30px">
								
								</div>
							</div>	
						</a>	

						<a href="#">
							<div class="single_promo">
								<img  src="<?php echo e(asset('images/cba/2.jpg')); ?>" alt="">
						
							</div>	
						</a>	
						
					</div><!--  End Col -->					

					<div class="col-lg-4 col-md-6 col-sm-12">
						<a href="#">    
							<div class="single_promo">
								<img  src="<?php echo e(asset('images/abc/2.jpg')); ?>" alt="">
				
							</div>
						</a>	
					</div><!--  End Col -->					
				</div>			
        </div>
    </section>
    <!-- Shop -->
    <div class="main_title chart_bg" id="main-title-custom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-6">
                    <h2 class="title text-center text-white">
                        <?php if(count($homepage_product) > 0): ?>
                            Our Products
                        <?php else: ?>
                            &nbsp;
                        <?php endif; ?>
                    </h2>
                </div>
             </div>
        </div>
    </div>
    <section class="shop_wrap">
        <div class="container" id="homepage-container">
            <?php echo $__env->make('frontend/_product', ['homepage_product' => $homepage_product ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </section>
      
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>