<?php

namespace App\ModelFilters\UserFilter;

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

}
