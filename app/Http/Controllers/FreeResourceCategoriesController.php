<?php

namespace App\Http\Controllers;

use App\freeResourceCategories;
use Illuminate\Http\Request;

class FreeResourceCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return freeResourceCategories::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        freeResourceCategories::create($data);
        return response()->json('Category has been created', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $category = freeResourceCategories::where('name', $category)->first();
        return response()->json( $category , 200);
    }
}
