<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class OrderFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function paymentStatus($id) {
        return $this->related('getOrderTransactionDetails', 'payment_status', '=', $id);
    }
    
    public function shippingStatus($id) {
        return $this->related('getOrderTransactionDetails', 'shipping_status', '=', $id);
    }

    public function order($order) {
        return $this->where('order_no', $order);
    }

    public function name($name) {
        return $this->where(function($q) use ($name) {
                    return $q->where('first_name', 'LIKE', "%$name%")
                                    ->orWhere('last_name', 'LIKE', "%$name%");
                });
    }

    public function phone($phone) {
        return $this->where('phone', 'LIKE', "$phone%");
    }

    public function company($company) {
        return $this->whereBeginsWith('company', $company);
    }

    public function email($email) {
        return $this->whereBeginsWith('email', $email);
    }

    public function street($street) {
        return $this->whereBeginsWith('street', $street);
    }

    public function street2($street2) {
        return $this->whereBeginsWith('street2', $street2);
    }

    public function city($city) {
        return $this->whereBeginsWith('city', $city);
    }

    public function state($state) {
        return $this->where('state', $state);
    }

    public function country($country) {
        return $this->where('country', $country);
    }

    public function from($from) {
        return $this->where('date_time', '>=', date("Y-m-d 00:00:00", strtotime($from)));
    }

    public function to($to) {
        return $this->where('date_time', '<=', date("Y-m-d 23:59:59", strtotime($to)));
    }

}
