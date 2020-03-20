<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class property_images extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $fillable = ['property_id', 'property_image_path'];
    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

}
