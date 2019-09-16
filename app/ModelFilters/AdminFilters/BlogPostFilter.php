<?php

namespace App\ModelFilters\AdminFilters;

use EloquentFilter\ModelFilter;

class BlogPostFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];


    public function name($name)
    {
        return $this->whereLike('name', $name);
    }

    public function postDescription($postDescription)
    {
        return $this->where('post_description', $postDescription);
    }

    public function publishDate($publishDate)
    {
        return $this->where('publish_date', $publishDate);
    }

    public function isPublished($isPublished)
    {
        return $this->where('is_published', $isPublished);
    }

    public function authorName($authorName)
    {
        return $this->whereLike('author_name', $authorName);
    }


}