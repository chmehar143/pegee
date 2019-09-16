<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Be Welled Medical')); ?></title>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('css/font-awesome.min.css')); ?>" rel="stylesheet">
    <!-- include summernote css-->
    <link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.6/summernote.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
          rel="stylesheet">
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>

    <script src="<?php echo e(asset('js/jquery-masked-input.js')); ?>"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <!-- include summernote js-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.6/summernote.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>-->
    <script src="<?php echo e(asset('js/jquery-sortable.js')); ?>"></script>
    <link href="<?php echo e(asset('css/app-custom.css')); ?>" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="<?php echo e(url('admin/home')); ?>">
                    <?php echo e(config('app.name', 'Be Welled Medical')); ?>

                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <?php if(Auth::guard('admin')->check()): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Admins <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li class="<?php echo e(isset($page) && $page == "create-admin" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('admin.create')); ?>">
                                        Create New Admin
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li class="<?php echo e(isset($page) && $page == "admins-list" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('admins.list')); ?>">
                                        View Admins
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Users <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li class="<?php echo e(isset($page) && $page == "users-list" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('users.list')); ?>">
                                        View Users
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Categories <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li class="<?php echo e(isset($page) && $page == "create-category" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('category.create')); ?>">
                                        Create Category
                                    </a>
                                </li>

                                <li role="separator" class="divider"></li>

                                <li class="<?php echo e(isset($page) && $page == "index-category" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('category.index')); ?>">
                                        View Categories
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Products <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li class="<?php echo e(isset($page) && $page == "create-product" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('product.create')); ?>">
                                        Create Product
                                    </a>
                                </li>

                                <li role="separator" class="divider"></li>

                                <li class="<?php echo e(isset($page) && $page == "index-product" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('product.index')); ?>">
                                        View Products
                                    </a>
                                </li>

                                <li role="separator" class="divider"></li>

                                <li class="<?php echo e(isset($page) && $page == "index-feedback" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('product_feedback.index')); ?>">
                                        Product Reviews
                                    </a>
                                </li>

                                <li role="separator" class="divider"></li>

                                <li class="<?php echo e(isset($page) && $page == "index-samples" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('samples.index')); ?>">
                                        Sample Requests
                                    </a>
                                </li>

                                <li role="separator" class="divider"></li>

                                <li class="<?php echo e(isset($page) && $page == "import" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('import.form')); ?>">
                                        Import CSV
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Offers <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li class="<?php echo e(isset($page) && $page == "create-offer" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('offer.create')); ?>">
                                        Create Offer
                                    </a>
                                </li>

                                <li role="separator" class="divider"></li>

                                <li class="<?php echo e(isset($page) && $page == "index-offer" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('offer.index')); ?>">
                                        View Offers
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Auto Ship <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li class="<?php echo e(isset($page) && $page == "create-autoShip" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('autoship.create')); ?>">
                                        Create Auto Ship
                                    </a>
                                </li>

                                <li role="separator" class="divider"></li>

                                <li class="<?php echo e(isset($page) && $page == "index-autoShip" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('autoship.index')); ?>">
                                        View Auto Ship
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Misc <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li class="<?php echo e(isset($page) && $page == "index-static-page" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('static_page.index')); ?>">
                                        Static Pages
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li class="<?php echo e(isset($page) && $page == "index-slider-image" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('slider.index')); ?>">
                                        Slider Images
                                    </a>
                                </li>

                                <li role="separator" class="divider"></li>
                                <li class="<?php echo e(isset($page) && $page == "settings" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('setting.index')); ?>">
                                        Settings
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li class="<?php echo e(isset($page) && $page == "meta_tags" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('meta_tags.index')); ?>">
                                        Meta Tags
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li class="<?php echo e(isset($page) && $page == "email_templates" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('email_templates.index')); ?>">
                                        Email Templates
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Orders <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li class="<?php echo e(isset($page) && $page == "index-order" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('order.index')); ?>">
                                        All Orders
                                    </a>
                                </li>
                                <li class="<?php echo e(isset($page) && $page == "pending-orders" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('order.pending')); ?>">
                                        Pending Orders
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Blog Posts<span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li class="<?php echo e(isset($page) && $page == "blog-posts" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('blog_posts.index')); ?>">Blog Posts
                                    </a>
                                </li>
                                <li class="<?php echo e(isset($page) && $page == "create-blog" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('blog_posts.create')); ?>">Create Blog Post
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li class="<?php echo e(isset($page) && $page == "blog-categories" ? 'active' : ''); ?>">
                                    <a href="<?php echo e(route('blog_categories.index')); ?>">List Blog Categories
                                    </a>
                                </li>
                            </ul>
                        </li>



                    <?php endif; ?>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <?php if(!Auth::guard('admin')->check()): ?>
                        <li><a href="<?php echo e(route('admin.login')); ?>">Admin Login</a></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <?php echo e(Auth::guard('admin')->user()->name); ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?php echo e(route('admin.logout')); ?>"
                                       onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>
</div>


</body>
</html>
