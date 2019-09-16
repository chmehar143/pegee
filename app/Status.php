<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

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
    protected $fillable = ['status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id'];

}
