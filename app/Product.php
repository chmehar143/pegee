<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model {

    use Filterable,
        Sluggable;

    /**
     * The attributes that should be guarded for arrays.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be fillable for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'product_picture',
        'product_quantity',
        'product_description',
        'short_description',
        'product_height',
        'product_width',
        'product_packaging',
        'product_code',
        'product_status',
        'out_of_stock',
        'sample_product',
        'show_video',
        'product_featured',
        'category_id',
        'out_of_stock_message'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'category_id',
    ];

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getCategory() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function getOffers() {
        return $this->hasMany('App\Offer');
    }

    public function getAutoShip() {
        return $this->hasOne('App\AutoShip');
    }

    public function getProductImages() {
        return $this->hasMany('App\ProductImage');
    }

    public function getActiveProductImages() {
        return $this->getProductImages()
                        ->where('product_image_status', 1)
                        ->orderBy('image_featured', 'DESC')
                        ->get();
    }

    public function getFeaturedImage() {
        return $this->getProductImages()
                        ->where('product_images.image_featured', 1)
                        ->where('product_images.product_image_status', 1)
                        ->first();
    }

    public function getOrderProducts() {
        return $this->hasMany('App\OrderDetail');
    }

    public function getActiveOffers() {
        return $this->getOffers()
                        ->where('offer_status', 1)
                        ->orderBy('offer', 'ASC')
                        ->get();
    }

    public function getApllyingOffer($productQuantity) {
        return $this->getOffers()
                        ->where('offer_status', 1)
                        ->where('quantity', '<=', $productQuantity)
                        ->orderBy('quantity', 'DESC')
                        ->first();
    }

    public function getMaxOffer() {
        return $this->getOffers()
                        ->where('offer_status', 1)
                        ->orderBy('quantity', 'DESC')
                        ->first();
    }

    public static function getProductWithOffers($params, $search) {
        return Product::select('products.*')->leftJoin('offers', 'products.id', '=', 'offers.product_id')
                        ->where('products.product_status', 1)
                        ->where('products.out_of_stock', 1)
                        ->where('products.product_quantity', '>', 0)
                        ->whereNotNull('offers.id')
                        ->filter($params, $search)
                        ->groupBy('products.id')
                        ->orderBy('products.weight')
                        ->paginateFilter(6);
    }

    public function getHomepageActiveOffers() {
        return $this->getOffers()
                        ->where('offer_status', 1)
                        ->limit(2)
                        ->get();
    }

    public function getSaleActiveOffers() {
        return $this->getOffers()
                        ->where('offer_status', 1)
                        ->limit(1)
                        ->get();
    }

    public function getActiveAutoShip() {
        return $this->getAutoShip()
                        ->where('autoship_status', 1)
                        ->first();
    }

    public function getOfferByProduct($qty, $id) {
        return $this->getOffers()
                        ->where('offer_status', 1)
                        ->where('quantity', $qty)
                        ->where('product_id', $id)
                        ->first();
    }

    public function getProductFeedbacks() {
        return $this->hasMany('App\ProductFeedback');
    }

    public function getApprovedProductFeedbacks() {
        return $this->getProductFeedbacks()
                        ->where('is_approved', 1)
                        ->latest()
                        ->limit(5)
                        ->get();
    }

    public function getApprovedProductFeedbacksCount() {
        return $this->getProductFeedbacks()
                        ->where('is_approved', 1)
                        ->get();
    }

    public function getSample() {
        return $this->hasMany('App\Sample');
    }

    public static function getProductsForFreeSamples(){
        return Product::where('product_status', 1)
            ->where('product_quantity', '>', 0)
            ->where('out_of_stock', 1)
            ->where('sample_product', 1)
            ->get();
    }

    public function getParsedName(){
        $patterns = array();
        $patterns[0] = '/ *\([^)]*\) */';
        $replacements = array();
        $replacements[0] = '';
        return preg_replace($patterns, $replacements, $this->name);
    }

}