<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {

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
        'product_image',
        'image_featured',
        'product_image_status',
        'product_id'
    ];
    
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

}
