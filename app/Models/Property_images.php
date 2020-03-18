<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property_images extends Model
{
// this class to store and get image for products this is a MODEL
     protected $fillable = [
        'property_id',
        'image'
    ];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

}
