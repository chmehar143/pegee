<?php $__env->startSection('title', isset($meta_tags) ? $meta_tags->title : "Blog - " . config('app.name', 'PetsWorld, Inc')); ?>
<?php $__env->startSection('meta_description', isset($meta_tags) ? $meta_tags->description : ''); ?>
<?php $__env->startSection('content'); ?>
    <!-- Section: inner-header -->
    <div class="main-content">
        <div class="main_title chart_bg">
            <div class="container text-center">
                <h1 class="title h2-style">Blog</h1>
            </div>
        </div>

        <section id="about">
            <div class="container pb-80">
                <div class="section-content">
                    <div class="row">
                        <div class="col-md-12">

                            <?php $__currentLoopData = $blog_posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog_post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="blog-post">
                                    <h2 class="post-title h3-style"><a
                                                href="<?php echo e(route('blog.show', ['slug' => $blog_post->slug])); ?>"><?php echo e($blog_post->name); ?></a>
                                    </h2>
                                    <?php if($blog_post->getBlogCategoryName() != ''): ?>
                                    <p><small>in Category</small> <?php echo e($blog_post->getBlogCategoryName()); ?></p>
                                    <?php endif; ?>
                                    <div class="post-description"><?php echo str_limit(strip_tags($blog_post->post_content), 500, '...'); ?></div>
                                    <p>by <?php echo e($blog_post->author_name); ?>

                                        - <?php echo e(Carbon\Carbon::parse($blog_post->publish_date)->format('M d, Y')); ?> </p>
                                    <hr/>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="text-center"><?php echo e($blog_posts->links()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>