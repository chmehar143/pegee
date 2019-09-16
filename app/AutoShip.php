<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class AutoShip extends Model {

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
        'autoship_percentage',
        'autoship_status',
        'product_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'product_id',
    ];

    public function getActiveShipProduct() {
        return $this->belongsTo('App\Product', 'product_id');
    }

}
