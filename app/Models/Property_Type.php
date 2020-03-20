<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class property_type extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];
    public function properties()
    {
        return  $this->belongsToMany('App\Models\Property', 'property_type_properties')->paginate(5);
    }
}
