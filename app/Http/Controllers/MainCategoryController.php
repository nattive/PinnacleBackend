<?php

namespace App\Http\Controllers;

use App\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main = MainCategory::with('SubCategories')->get();
        return json_encode($main);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request -> all();

        $data = $request->validate([
            'name' => 'required'
        ]);

        MainCategory::create($data);
        return response('Main Category Updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $mainCategory = MainCategory::find($id);
       $category = $mainCategory -> SubCategories ;
        return response(['mainCategory' => $category]);  //
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
        $data = $request->validate([
            'name' => 'required'
        ]);
        $mainCategory = MainCategory::find($id);
        $mainCategory -> name = $request ->name;
        $mainCategory -> save();
        return response('Main Category Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mainCategory = MainCategory::find($id);
        return response('Main Category Updated');
        $mainCategory -> delete();
        return response('Main Category deleted');

    }
}
