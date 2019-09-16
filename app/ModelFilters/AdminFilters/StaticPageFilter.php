<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class StaticPageFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function name($name) {
        return $this->whereBeginsWith('page_name', $name);
    }

    public function show($show) {
        return $this->where('page_show', $show);
    }

    public function status($status) {
        return $this->where('page_status', $status);
    }

}
