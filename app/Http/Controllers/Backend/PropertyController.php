<?php



namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\property_type;
use App\Models\listing_type;
use App\Models\rooms_type;
use App\Models\property_images;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
        $properties = Property::all();
        return view('backend.property.index', compact('properties'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $property_types = property_type::all();
        $listing_types = listing_type::all();
        $rooms_types = rooms_type::all();
        return view('backend.property.create',compact('property_types', 'listing_types', 'rooms_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'price' => 'required',
        ]);

        // Start of Upload Files
        if ($request->hasFile('f_image')) {
            $fileNameWithExt = $request->file('f_image')->getClientOriginalName();
            // get file name
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get extension
            $extension = $request->file('f_image')->getClientOriginalExtension();

            $fileNameToStore =  time() . '.' . $extension;
            // upload
            $path = $request->file('f_image')->move('uploads/properties', $fileNameToStore);
        } else {
            $fileNameToStore = '';
        }


        $property = new Property;
        $property->f_image = $fileNameToStore;
        $property->price = $request['price'];
        $property->area_size = $request['area_size'];
        $property->location = $request['location'];
        $property->description = $request['description'];
        $property->user_id = Auth::user()->id;
        $property->save();

        $property->property_types()->sync($request->property_type);
        $property->rooms_types()->sync($request->rooms_type);
        $property->listing_types()->sync($request->listing_type);
        return redirect(route('admin.property.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $Property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $Property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::where('id', $id)->first();
        $property_types = property_type::all();
        $listing_types = listing_type::all();
        $rooms_types = rooms_type::all();
        return view('backend.property.edit', compact('property','property_types', 'listing_types', 'rooms_types'));
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
        $this->validate($request, [
            "price" => "required",
        ]);

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
        return redirect(route('admin.property.index'));
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
        if ($property_images) {
            foreach ($property_images as $image) {
                unlink('uploads/properties/' . $image->property_image_path);
            }
        }
        if (!($property->f_image == '')) {
            unlink('uploads/properties/' . $property->f_image);
        }
        $property->delete();

        return redirect()->back();
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = Config::get('app.APP_URL') . $uploadPath;
    }

    // public function deleteImage($id)
    // {
    //     //For Deleting
    //     $images = new property_images();
    //     $images = property_images::find($id);
    //     File::delete($this->getUploadPath() . $images->property_image_path);
    //     $images->delete($id);
    //     return response()->json([
    //         'success' => 'Data has been deleted successfully!'
    //     ]);
    // }

}
