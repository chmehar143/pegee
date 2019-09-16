<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model {

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
        'company',
        'street',
        'street2',
        'city',
        'state',
        'postal_code',
        'country',
        'currently_using',
        'weight',
        'is_approved',
        'product_id',
        'product_id2',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'product_id',
        'product_id2',
        'user_id',
    ];

    public function getProduct1() {
        return $this->belongsTo('App\Product', 'product_id');
    }
    
    public function getProduct2() {
        return $this->belongsTo('App\Product', 'product_id2');
    }

    public function getUser() {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function getFullAddress(){
        $fullAddress = [$this->street];
        if($this->street2){
            array_push($fullAddress, $this->street2);
        }
        array_push($fullAddress, $this->city);
        array_push($fullAddress, $this->state);
        array_push($fullAddress, $this->postal_code);
        return implode(", ", $fullAddress);

    }

}
