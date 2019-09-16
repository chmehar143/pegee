<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
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
    protected $fillable = [
        'sample_request',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];


    public static function getDefaultSettings(){
        $defaultSettings = Setting::first();
        if(!$defaultSettings){
            $defaultSettings = new Setting();
            $defaultSettings->sample_request = 1;
            $defaultSettings->save();
        }
        return $defaultSettings;

    }

}
