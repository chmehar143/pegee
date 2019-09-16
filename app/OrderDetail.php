<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {

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
        'price',
        'discount',
        'quantity',
        'autoship_discount',
        'autoship_interval',
        'date_time',
        'special_discount',
        'order_id',
        'product_id',
        'offer_id',
        'autoship_id',
        'transaction_id',
        'payment_status',
        'shipping_status',
        'error_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'order_id',
        'product_id',
        'offer_id',
        'autoship_id',
    ];

    public function getOrder() {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function getProductDetail() {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function getOfferDetail() {
        return $this->belongsTo('App\Offer', 'offer_id');
    }

    public function getOrderTransactionDetails() {
        return $this->hasMany('App\OrderTransactionDetail');
    }

    public function getRecentTransactionDetail(){
        return $this->getOrderTransactionDetails()->latest()->first();
    }


    public function getFirstTransaction(){
        return $this->getOrderTransactionDetails()->oldest()->first();
    }

    public function getTransactions($direction = 'asc'){
        return $this->getOrderTransactionDetails()->orderBy('id', $direction)->get();
    }


}
