<?php



namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property_type;

class PropertyTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property_types = property_type::all();
        return view('backend.property_type.index', compact('property_types'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.property_type.create');
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
            'name' => 'required',
        ]);

        $property_type = new property_type;
        $property_type->name = $request['name'];
        $property_type->save();
        return redirect(route('admin.property_type.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\property_type  $property_type
     * @return \Illuminate\Http\Response
     */
    public function show(property_type $property_type)
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
        $property_type = property_type::where('id', $id)->first();
        return view('backend.property_type.edit', compact('property_type'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, property_type $property_type)
    {
        $this->validate($request, [
            "name" => "required",
        ]);
        $property_type->name = $request['name'];
        $property_type->save();
        return redirect(route('admin.property_type.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(property_type $property_type)
    {
        $property_type->delete();
        return redirect()->back();
    }



}
