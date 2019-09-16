<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ProductFeedback extends Model {

    use Filterable;

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
        'rating',
        'subject',
        'product_feedback',
        'is_anonymous',
        'is_approved',
        'user_id',
        'product_id',
        'review_date',
        'display_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'product_id',
    ];

    public function getProduct() {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function getUser() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getOrder() {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public static function getAverageRating($product_id) {
        return ProductFeedback::where('product_id', $product_id)
                        ->where('is_approved', 1)
                        ->avg('rating');
    }

    public static function getReviewsCount($product_id) {
        return ProductFeedback::where('product_id', $product_id)
                        ->where('is_approved', 1)
                        ->count();
    }

}
