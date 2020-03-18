<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

    public function user()
    {
        // return $this->belongsTo('App\Models\Auth\User');
        return $this->belongsToMany('App\Models\Auth\User', 'user_properties');
    }


    public function property_types()
    {
        return  $this->belongsToMany('App\Models\Property_type', 'property_type_properties')->withTimestamps();
    }

    public function listing_types()
    {
        return  $this->belongsToMany('App\Models\Listing_Type', 'listing_type_properties')->withTimestamps();
    }

    public function rooms_types()
    {
        return  $this->belongsToMany('App\Models\Rooms_Type', 'rooms_type_properties')->withTimestamps();
    }


    // this fucntion is to join images model with prodcut model
    public function property_images()
    {
        return $this->hasMany('App\Models\Property_images');
    }
}
