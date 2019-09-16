<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplateAttribute extends Model
{
    //

    public function getHumanizedKey(){
        return ucfirst(str_replace("_", " ", $this->attr_key));

    }
}
