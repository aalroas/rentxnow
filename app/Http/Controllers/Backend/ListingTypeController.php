<?php



namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\listing_type;

class ListingTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listing_types = listing_type::all();
        return view('backend.listing_type.index', compact('listing_types'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.listing_type.create');
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

        $listing_type = new listing_type;
        $listing_type->name = $request['name'];
        $listing_type->save();
        return redirect(route('admin.listing_type.index'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\listing_type  $listing_type
     * @return \Illuminate\Http\Response
     */
    public function show(listing_type $listing_type)
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
        $listing_type = listing_type::where('id', $id)->first();
        return view('backend.listing_type.edit', compact('listing_type'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, listing_type $listing_type)
    {
        $this->validate($request, [
            "name" => "required",
        ]);
        $listing_type->name = $request['name'];
        $listing_type->save();
        return redirect(route('admin.listing_type.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(listing_type $listing_type)
    {
        $listing_type->delete();
        return redirect()->back();
    }



}
