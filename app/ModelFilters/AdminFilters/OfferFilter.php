<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class OfferFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function product($product) {
        return $this->where('product_id', $product);
    }

    public function offer($offer) {
        return $this->where('offer', $offer);
    }

    public function quantity($quantity) {
        return $this->where('quantity', $quantity);
    }

    public function status($status) {
        return $this->where('offer_status', $status);
    }

}
