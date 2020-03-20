<?php

namespace App\Http\Controllers\API;

use App\Models\Rooms_Type;
use App\Models\Listing_Type;
use App\Models\Property_Type;
use App\Http\Controllers\Controller;


class PropertyOptionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing_type()
    {
        return response()->json(Listing_Type::get(['id', 'name']));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function property_type()
    {
        return response()->json(Property_Type::get(['id', 'name']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rooms_type()
    {
        return response()->json(Rooms_Type::get(['id', 'name']));
    }

}
