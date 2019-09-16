<!-- start Bxslider -->
<ul class="slider">
    <?php if(!is_null($home_sliders) && count($home_sliders) > 0): ?>
        <?php $__currentLoopData = $home_sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php if($slider->layer_1): ?>
                    <a href="<?php echo e($slider->layer_1); ?>">
                        <?php endif; ?>
                        <img src="<?php echo e(asset('uploads/slider/images/'. $slider->slider_image)); ?>" alt="<?php echo e($slider->layer_2); ?>" />
                        <?php if($slider->layer_1): ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <li><img src="<?php echo e(asset('images/slider1.jpg')); ?>"></li>
    <?php endif; ?>
</ul>
<!-- end Bxslider-->

<!-- Js BxSlider Initialize the slider-->
<script type="text/javascript">
    $(document).ready(function () {
        $('.slider').bxSlider({
            responsive: true,
            auto: true,
            controls: false,
            hideControlOnEnd: false,
            pager: false,
            touchEnabled: false,
            adaptiveHeight: 450,
        });
    });
</script>