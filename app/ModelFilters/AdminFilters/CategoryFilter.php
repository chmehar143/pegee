<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class CategoryFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function category($category) {
        return $this->where('parent_id', $category);
    }

    public function name($name) {
        return $this->whereBeginsWith('name', $name);
    }

    public function status($status) {
        return $this->where('status', $status);
    }

}
