<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentTracking extends Model
{
    /**
     * The attributes that should be fillable for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'order_transaction_detail_id',
        'status_code',
        'status_description',
        'tracking_datetime'
    ];


}
