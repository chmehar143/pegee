<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model {

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
    protected $fillable = ['offer', 'quantity', 'offer_status', 'product_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'product_id',
    ];

    public function getProduct() {
        return $this->belongsTo('App\Product', 'product_id');
    }
    
    public function getOrderOffers() {
        return $this->hasMany('App\OrderDetail');
    }

}
