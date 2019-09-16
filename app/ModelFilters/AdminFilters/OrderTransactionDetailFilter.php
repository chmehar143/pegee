<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class OrderTransactionDetailFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function paymentStatus($paymentStatus) {
        return $this->where('payment_status', $paymentStatus);
    }

    public function shippingStatus($shippingStatus) {
        return $this->where('shipping_status', $shippingStatus);
    }

}
