<?php
namespace App\ModelFilters\AdminFilters;
use EloquentFilter\ModelFilter;

class MetaTagFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function resourceId($resource_id){
        return $this->where('resource_id', $resource_id);
    }

    public function resourceType($resource_type){
        return $this->where('resource_type', $resource_type);
    }

    public function description($description){
        return $this->whereLike('description', $description);
    }

    public function title($title){
        return $this->whereLike('title', $title);
    }

}
