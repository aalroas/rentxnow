<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PropertyCollection extends Resource
{

    // all propertis
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user()->get(['id', 'first_name', 'last_name','avatar_location','avatar_type']),
            'f_image' => asset('uploads/properties/') . "/" . $this->f_image,
            'price' => $this->price,
            'area_size' => $this->area_size,
            'location' => $this->location,
            'description' =>  $this->description,
            'property_type' =>  $this->property_types()->get(['id', 'name']),
            'rooms_type' =>  $this->rooms_types()->get(['id', 'name']),
            'listing_type' =>  $this->listing_types()->get(['id', 'name']),
            'created_at' =>   $this->created_at->format('d/m/Y h:m:s'),
            'updated_at' => $this->updated_at->format('d/m/Y h:m:s'),
        ];
    //    return parent::toArray($request);
    }
}
