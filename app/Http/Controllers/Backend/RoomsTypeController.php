<?php



namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\rooms_type;

class RoomsTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms_types = rooms_type::all();
        return view('backend.rooms_type.index', compact('rooms_types'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.rooms_type.create');
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

        $rooms_type = new rooms_type;
        $rooms_type->name = $request['name'];
        $rooms_type->save();
        return redirect(route('admin.rooms_type.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rooms_type  $rooms_type
     * @return \Illuminate\Http\Response
     */
    public function show(rooms_type $rooms_type)
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
        $rooms_type = rooms_type::where('id', $id)->first();
        return view('backend.rooms_type.edit', compact('rooms_type'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rooms_type $rooms_type)
    {
        $this->validate($request, [
            "name" => "required",
        ]);
        $rooms_type->name = $request['name'];
        $rooms_type->save();
        return redirect(route('admin.rooms_type.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(rooms_type $rooms_type)
    {
        $rooms_type->delete();
        return redirect()->back();
    }



}
