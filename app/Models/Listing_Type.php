<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class listing_type extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];
    public function properties()
    {
        return  $this->belongsToMany('App\Models\Property', 'listing_type_properties')->paginate(5);
    }



}
