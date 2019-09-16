<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class SampleFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function product($product) {
        return $this->where('product_id', $product);
    }
    
    public function weight($weight){
        return $this->where('weight', $weight);
    }
    
    public function approved($approved){
        return $this->where('is_approved', $approved);
    }

}
