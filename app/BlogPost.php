<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{

    use Filterable,
        Sluggable;

    /**
     * The attributes that should be guarded for arrays.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be fillable for arrays.
     *
     * @var array
     */
    protected $fillable = ['name', 'post_content', 'publish_date', 'author_name', 'is_published', 'slug'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    /**
     * Slug column configuration
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getBlogCategory()
    {
        return $this->belongsTo('App\BlogCategory', 'blog_category_id', 'id');
    }

    public function getBlogCategoryName()
    {
        $blogCategory = $this->getBlogCategory;
        if ($blogCategory) {
            return $blogCategory->name;
        }
        return "";
    }


}
