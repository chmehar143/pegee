<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class StaticPage extends Model {

    use Filterable,
        Sluggable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be fillable for arrays.
     *
     * @var array
     */
    protected $fillable = ['page_name', 'page_description', 'page_status', 'page_show'];

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'page_name'
            ]
        ];
    }

}
