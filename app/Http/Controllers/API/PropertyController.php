<?php

namespace App\Http\Controllers\API;

use App\Models\Property;
use App\Models\property_images;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Controllers\Resources\PropertyResource;
use App\Http\Controllers\Resources\PropertyCollection;

class PropertyController extends Controller
{
    private $uploadPath = "uploads/properties/";
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
            $fileNameToStore = '';
        }


        $property = new Property();

        $property->f_image = $fileNameToStore;
        $property->price = $request['price'];
        $property->area_size = $request['area_size'];
        $property->location = $request['location'];
        $property->description = $request['description'];
        $property->user_id = $request->user()->id;
        $property->save();
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
    public function update(Request $request, Property $property)
    {

        $input = $request->all();

        $validator = Validator::make($input, [
            "price" => "required",

        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => 'Validation Error.',
                'message' => $validator->errors()
            ];
            return response()->json($response, 404);
        }

        // Start of Upload Files
        if ($request->hasFile('f_image')) {
            $path = $this->getUploadPath();
            if ($property->f_image != "") {
                unlink($path . $property->f_image);
            }
            $fileNameToUpadte =  time() . '.jpg';
            $path = $request->file('f_image')->move($path, $fileNameToUpadte);
        }



        $property->f_image = $fileNameToUpadte;
        $property->price = $request['price'];
        $property->area_size = $request['area_size'];
        $property->location = $request['location'];
        $property->description = $request['description'];

        $property->save();

        if ($request->hasFile('property_images')) {
            $all_images = $request->file('property_images');
            $path = $this->getUploadPath();
            foreach ($all_images as $file) {
                $image_name = time() . '.png';
                $file->move($path, $image_name);
                $images = new property_images();
                $images->property_id = $property->id;
                $images->property_image_path = $image_name;
                $images->save();
            }
        }


        $property->property_types()->sync($request->property_type);
        $property->rooms_types()->sync($request->rooms_type);
        $property->listing_types()->sync($request->listing_type);
        $property->property_images()->get(['id', 'property_image_path']);

        $data = $property->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Property  updated successfully.'
        ];

        return response()->json($response, 200);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Property $property)
    {


        $property_images = property_images::where('property_id', $property)->get();
        if($property_images){
            foreach ($property_images as $image) {
                unlink('uploads/properties/' . $image->property_image_path);
            }
        }
        if (!($property->f_image == '')) {
            unlink('uploads/properties/' . $property->f_image);
        }
        $property->delete();
        $data = $property->toArray();


        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Property deleted successfully.'
        ];

        return response()->json($response, 200);
    }


    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = Config::get('app.APP_URL') . $uploadPath;
    }
}
