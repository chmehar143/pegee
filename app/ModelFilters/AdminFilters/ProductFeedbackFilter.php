<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class ProductFeedbackFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function rating($rating) {
        return $this->where('rating', $rating);
    }

    public function product($product) {
        return $this->where('product_id', $product);
    }

    public function user($user) {
        return $this->where('user_id', $user);
    }

    public function anonymous($anonymous) {
        return $this->where('is_anonymous', $anonymous);
    }

    public function status($approved) {
        return $this->where('is_approved', $approved);
    }

}
