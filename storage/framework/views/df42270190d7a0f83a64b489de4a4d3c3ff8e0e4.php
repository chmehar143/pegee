<?php $__env->startSection('title', isset($meta_tags) ? $meta_tags->title : $title . " - " . config('app.name', 'PetsWorld, Inc')); ?>
<?php $__env->startSection('meta_description', isset($meta_tags) ? $meta_tags->description : ''); ?>
<?php $__env->startSection('content'); ?>

    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h2 class="title">Sample Request</h2>
            </div>
        </div>

        <section class="divider">
        <div class="container">
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo e(session('success')); ?>

                </div>
            <?php elseif(session('error')): ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <div class="section-content">
                <div class="row mt-30">
                    <?php if($success): ?>
                        <?php echo $__env->make("sample._form", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php elseif($already_submitted): ?>
                        <?php echo $__env->make("sample._details", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </section>
    </div>

    <?php echo $__env->make('sample._size_chart_model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#sample-request').submit(function () {
                $(this).find(':input[type=submit]').prop('disabled', true);
                $(".gender_class").prop('disabled', false);
            });
        });

        $(window).load(function () {
            var phones = [{"mask": "(###) ###-####"}];
            $('#phone-no').inputmask({
                mask: phones,
                greedy: false,
                definitions: {'#': {validator: "[0-9]", cardinality: 1}}
            });
        });

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>