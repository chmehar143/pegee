<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class AutoShipFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function percentage($percentage) {
        return $this->where('autoship_percentage', $percentage);
    }

    public function product($product) {
        return $this->where('product_id', $product);
    }

    public function status($status) {
        return $this->where('autoship_status', $status);
    }

}
