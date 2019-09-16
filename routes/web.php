<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//Route::get('/', function () {
//    return view('frontend.frontend');
//});
Route::get('/', 'FrontendController@home')->name('homepage');

Auth::routes();

/* Admins Backend Routes */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {

    /**
     * Auth routes 
     */
    Route::get('login', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

    /**
     * Home routes 
     */
    Route::get('home', 'HomeController@index')->name('admin.home.home');

    /**
     * Admin routes 
     */
    Route::get('list', 'AdminUserController@showAdminsList')->name('admins.list');
    Route::get('form/create', 'AdminUserController@showAdminForm')->name('admin.create');
    Route::post('form/save', 'AdminUserController@saveAdminForm')->name('admin.save');
    Route::get('form/edit/{id}', 'AdminUserController@editAdminForm')->name('admin.edit');
    Route::post('form/update', 'AdminUserController@updateAdminForm')->name('admin.update');
    Route::get('form/delete/{id}', 'AdminUserController@deleteAdminForm')->name('admin.delete');
    Route::resource('setting', 'SettingController');

    /**
     * User routes 
     */
    Route::get('list/users', 'UserController@showUsersList')->name('users.list');
    Route::get('form/user/edit/{id}', 'UserController@editUserForm')->name('user.edit');
    Route::post('form/user/update', 'UserController@updateUserForm')->name('user.update');
    Route::get('form/user/activate/{id}', 'UserController@activateUserForm')->name('user.activate');
    Route::get('form/user/deactivate/{id}', 'UserController@deactivateUserForm')->name('user.deactivate');
    Route::get('form/user/block/{id}', 'UserController@blockUserForm')->name('user.block');
    Route::get('sample/request/enable/{id}', 'UserController@enableSampleRequest')->name('enable.request');
    Route::get('sample/request/disable/{id}', 'UserController@disableSampleRequest')->name('disable.request');

    /**
     * Import routes 
     */
    Route::get('form/import', 'ImportController@importForm')->name('import.form');
    Route::post('form/file', 'ImportController@importFile')->name('import.file');


    Route::resource('category', 'CategoryController');
    Route::get('category/activate/{id}', 'CategoryController@getActivate')->name('category.activate');
    Route::get('category/deactivate/{id}', 'CategoryController@getDeactivate')->name('category.deactivate');

    /**
     * Product routes 
     */
    Route::resource('product', 'ProductController');
    Route::get('product/activate/{id}', 'ProductController@getActivate')->name('product.activate');
    Route::get('product/deactivate/{id}', 'ProductController@getDeactivate')->name('product.deactivate');
    Route::patch('product/feature/{id}', 'ProductController@setFeaturedImage')->name('feature.update');
    Route::delete('product/image/{id}', 'ProductController@deleteImage')->name('image.delete');
    Route::get('product/instock/{id}', 'ProductController@getInStock')->name('product.instock');
    Route::get('product/outstock/{id}', 'ProductController@getOutOfStock')->name('product.outstock');
    Route::get('product/activevideo/{id}', 'ProductController@setActiveVideo')->name('product.acvideo');
    Route::get('product/disablevideo/{id}', 'ProductController@setDisableVideo')->name('product.dsvideo');
    Route::get('product/sample/enable/{id}', 'ProductController@sampleProductEnable')->name('product.ensample');
    Route::get('product/sample/disable/{id}', 'ProductController@sampleProductDisable')->name('product.dssample');

    /**
     * Offer routes
     */
    Route::resource('offer', 'OfferController');
    Route::get('offer/activate/{id}', 'OfferController@getActivate')->name('offer.activate');
    Route::get('offer/deactivate/{id}', 'OfferController@getDeactivate')->name('offer.deactivate');

    /**
     * Static page routes 
     */
    Route::resource('static_page', 'StaticPageController');
    Route::get('page/activate/{id}', 'StaticPageController@getActivate')->name('page.activate');
    Route::get('page/deactivate/{id}', 'StaticPageController@getDeactivate')->name('page.deactivate');

    /**
     * Slider routes
     */
    Route::resource('slider', 'SliderController');
    Route::get('slider/activate/{id}', 'SliderController@getActivate')->name('slider.activate');
    Route::get('slider/deactivate/{id}', 'SliderController@getDeactivate')->name('slider.deactivate');

    /**
     * Order routes
     */
    Route::resource('order', 'OrderController');
    Route::get('order/invoice/{id}', 'OrderController@orderInvoice')->name('order.invoice');
    Route::get('order_detail/{id}/subscriptions', 'OrderController@getSubscriptionTransactions')->name('order.subscriptions');
    Route::get('orders/pending', 'OrderController@getPendingOrders')->name('order.pending');
    Route::get('order/update/{order_id}/address', 'OrderController@getUpdateOrderAddress')->name('admin.order.address');
    Route::POST('order/update/{order_id}/address', 'OrderController@updateOrderAddress')->name('admin.order.address-update');

    /**
     * Auto ship routes
     */
    Route::resource('autoship', 'AutoShipController');
    Route::get('autoship/activate/{id}', 'AutoShipController@getActivate')->name('autoship.activate');
    Route::get('autoship/deactivate/{id}', 'AutoShipController@getDeactivate')->name('autoship.deactivate');

    /**
     * Product feedback routes
     */
    Route::resource('product_feedback', 'ProductFeedbackController');
    Route::get('product_feedback/approved/{id}', 'ProductFeedbackController@getApproved')->name('feedback.approved');
    Route::get('product_feedback/disapproved/{id}', 'ProductFeedbackController@getDisapproved')->name('feedback.disapproved');

    /**
     * Authorize.net Routes
     */
    Route::get('authorize/refund-transaction/{id}', 'AuthnetController@refundTransaction')->name('refund.transaction');

    /**
     * Sample Routes
     */
    Route::resource('samples', 'SampleController');
    Route::get('samples/request/approve/{id}', 'SampleController@approveSample')->name('samples.approve');
    Route::resource('meta_tags', 'MetaTagController');
    /**
     * EmailTemplates Routes
     */
    Route::resource('email_templates', 'EmailTemplateController');

    Route::resource('blog_posts', 'BlogPostController');
    Route::resource('blog_categories', 'BlogCategoryController');

});
//Route::get('home', 'HomeController@index')->name('home')->middleware('auth');

/**
 * User routes
 */
Route::get('user/profile/edit', 'UserController@editUserProfile')->name('edit.profile')->middleware('auth');
Route::patch('user/profile/update', 'UserController@updateUserProfile')->name('update.profile')->middleware('auth');

/**
 * Shop routes
 */
Route::get('shop', 'ShopController@shop')->name('shop');

/**
 * Today deal routes
 */
Route::get('deals', 'TodayDealController@index')->name('deal');

/**
 * Product routes
 */
Route::get('product/{slug}', 'ProductController@product')->name('product');

/**
 * Category routes
 */
Route::get('category/{slug}', 'CategoryController@category')->name('category');

/**
 * Contact us routes
 */
Route::post('message/contact', 'ContactUsController@contactUs')->name('message.contact');

/**
 * Blog Routes
 */

Route::get('/blog', 'BlogController@index')->name('blog.index');
Route::get('/blog/{slug}', 'BlogController@show')->name('blog.show');
Route::get('/reviews', 'FrontendController@shopperApprovedReviews')->name('reviews.list');

/**
 * Static page routes
 */
Route::get('{slug}', 'StaticPageController@staticPage')->name('static-page');

/**
 * Cart routes
 */
Route::resource('shop/cart', 'CartController');
Route::get('cart/checkout', 'CartController@cartCheckout')->name('checkout');
Route::post('save/checkout', 'CartController@saveCheckout')->name('save.checkout');
Route::delete('cart/empty', 'CartController@emptyCart')->name('empty.cart');
Route::post('cart/switch/{id}', 'CartController@switchToWishlist')->name('switch.wishlist');
Route::get('authorize/confirm-order/{order_no}', 'CartController@getConfirmOrder')->name('confirm.order');
Route::get('redirected/to/login/subscription', 'CartController@redirectedToLoginIfAutoship')->name('redirected.subscription');

/**
 * Wishlist routes
 */
Route::resource('shop/wishlist', 'WishlistController');
Route::delete('wishlist/empty', 'WishlistController@emptyWishlist')->name('empty.wishlist');
Route::post('wishlist/switch/{id}', 'WishlistController@switchToCart')->name('switch.cart');

/**
 * Paypal routes
 */
// Route::get('paypal/checkout', 'PayPalController@getExpressCheckout')->name('paypal.checkout');
// Route::get('paypal/checkout-success', 'PayPalController@getExpressCheckoutSuccess')->name('paypal.success');
// Route::get('paypal/cancel-request', 'PayPalController@getCancelRequest')->name('cancel.request');
// Route::get('paypal/confirm-order', 'PayPalController@getConfirmOrder')->name('confirm.order');

/**
 * Order routes
 */
Route::get('user/orders', 'OrderController@getOrders')->name('order');
Route::get('order/details/{order_id}', 'OrderController@getOrderdetails')->name('order.detail');
Route::get('order/success/{order_id}', 'OrderController@orderSuccess')->name('order.success');
Route::get('order/update/{order_id}/address', 'OrderController@getUpdateOrderAddress')->name('order.address');
Route::POST('order/update/{order_id}/address', 'OrderController@updateOrderAddress')->name('order.address-update');
Route::get('track/order', 'OrderController@getTrack')->name('track.order');
Route::POST('order/track', 'OrderController@getTrackDetail')->name('order.track');

/**
 * Product feedback routes
 */
Route::resource('customer/feedback', 'ProductFeedbackController');

/**
 * Authorize .net routes
 */
Route::get('authorize/cancel-request/{id}', 'AuthnetController@cancelSubscription')->name('cancel.subscription');
Route::get('authorize/update-subscription/{id}', 'AuthnetController@getUpdateSubscription')->name('get.subscription');
Route::POST('authorize/update-subscription', 'AuthnetController@updateSubscription')->name('update.subscription');
Route::POST('authorize/payment-status', 'AuthnetController@subscriptionTransactionCallback')->name('payment.status');


/**
 * Sample Request routes
 */
Route::get('sample/request', 'SampleController@index')->name('sample.request');
Route::post('sample/request', 'SampleController@sampleRequest')->name('request.sample');

/**
 * Email Testing routes
 */
Route::get('email/check/server', 'CartController@getEmailTestLiveServer')->name('email.check');
