<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rooms_type extends Model
{
    public function properties()
    {
        return  $this->belongsToMany('App\Models\Property', 'rooms_type_properties')->paginate(5);
    }

}
