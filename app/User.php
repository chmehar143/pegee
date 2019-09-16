<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Filterable,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_picture',
        'phone_no',
        'gender',
        'status',
        'sample_request',
        'sample_request_count',
        'last_login_date',
        'login_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'profile_picture', 'remember_token',
    ];

    public function getOrders() {
        return $this->hasMany('App\Order');
    }

    public function getUserProductsFeedbacks() {
        return $this->hasMany('App\Order');
    }

    public function getApprovedUserProductFeedbacks() {
        return $this->getUserProductsFeedbacks()
                        ->where('is_approved', 1)
                        ->first();
    }

    public function getLatestOrder() {
        return $this->getOrders()
                        ->where('payment_status', 1)
                        ->where('status', 4)
                        ->latest()
                        ->first();
    }
    
    public function getSample(){
        return $this->hasOne('App\Sample');
    }

    public function getName(){
        return $this->first_name . " " . $this->last_name;
    }

}
