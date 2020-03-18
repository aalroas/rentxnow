<?php

namespace App\Http\Controllers\API;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Controllers\Resources\PropertyResource;
use App\Http\Controllers\Resources\PropertyCollection;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PropertyCollection::collection(Property::paginate(20));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            "price"=> "required",
        ]);


        if ($validator->fails()) {
            // return response
            $response = [
                'success' => false,
                'message' => 'Validation Error.', $validator->errors(),
            ];
            return response()->json($response, 404);
        }


        // Start of Upload Files
        if ($request->hasFile('f_image')) {
            $fileNameToStore =  time() . '.jpg';
            // upload
            $path = $request->file('f_image')->move('uploads/properties', $fileNameToStore);
        } else {
            $fileNameToStore = 'no_image.jpg';
        }


        $property = new Property();

        $property->f_image = $fileNameToStore;
        $property->price = $request['price'];
        $property->area_size = $request['area_size'];
        $property->location = $request['location'];
        $property->description = $request['description'];

        $property->save();

        $property->user()->sync($request->user()->id);
        $property->property_types()->sync($request->property_type);
        $property->rooms_types()->sync($request->rooms_type);
        $property->listing_types()->sync($request->listing_type);


        $data = $property->toArray();

        // return response

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Property stored successfully.'
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response =  Property::where('id', $id)->get();
        return  PropertyResource::collection($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // // Start of Upload Files
        // if ($request->hasFile('activity_images')) {
        //     $all_images = $request->file('activity_images');
        //     $path = $this->getUploadPath();
        //     foreach ($all_images as $file) {
        //         $image_name = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
        //         $file->move($path, $image_name);
        //         $activity_images = new activity_images;
        //         $activity_images->activity_id = $activity->id;
        //         $activity_images->activity_image_path = $image_name;
        //         $activity_images->save();
        //     }
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
