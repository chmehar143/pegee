<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function category($category) {
        return $this->where('category_id', $category);
    }

    public function product($product) {
        return $this->whereBeginsWith('name', $product);
    }

    public function price($price) {
        return $this->where('price', $price);
    }

    public function quantity($quantity) {
        return $this->where('product_quantity', $quantity);
    }

    public function description($description) {
        return $this->whereBeginsWith('product_description', $description);
    }

    public function code($code) {
        return $this->whereBeginsWith('product_code', $code);
    }

    public function status($status) {
        return $this->where('product_status', $status);
    }

    public function outofstock($outofstock) {
        return $this->where('out_of_stock', $outofstock);
    }
    
    public function samplerequest($samplerequest){
        return $this->where('sample_product', $samplerequest);
    }

}
