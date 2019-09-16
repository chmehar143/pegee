<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class SliderFilter extends ModelFilter {

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function layerOne($layerOne) {
        return $this->whereBeginsWith('layer_1', $layerOne);
    }

    public function layerTwo($layerTwo) {
        return $this->whereBeginsWith('layer_2', $layerTwo);
    }

    public function layerThree($layerThree) {
        return $this->whereBeginsWith('layer_3', $layerThree);
    }

    public function layerFour($layerFour) {
        return $this->whereBeginsWith('layer_4', $layerFour);
    }

    public function status($status) {
        return $this->where('slider_image_status', $status);
    }

}
