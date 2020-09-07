<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Requests\TutorRequest;
use App\Tutor;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TutorRequest $request)
    {
      $tutor = Tutor::create($request -> validated());
       return response()->json( $tutor, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createTutorAdmin(Request $request, $id)
    {
        // return $request->all();
        try {
            $admin = Admin::where('id', $id)->first();
            $validate = $request->validate([
                'isPO_tutor' => '',
                'name' => 'required',
                'image' => '',
                'about' => '',
                'files' => '',
                'facebook' => '',
                'twitter' => '',
                'instagram' => '',
                'youTube' => '',
                'admin_id' => '',
                'linkedIn' => '',
                'isCotF_tutor' => '',
            ]);
            $updated = [
                'isAdmin' => true,
                'isActive' => true,
                'admin_id' => $request->user_id,
            ];
            $tutor = Tutor::create(array_merge($validate, $updated));
            $admin->tutor_id = $tutor->id;
            $admin->save();
            return response(200);
            //code...
        } catch (\Throwable $th) {
            return response($th, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function show(Tutor $tutor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function edit(Tutor $tutor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tutor $tutor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tutor $tutor)
    {
        //
    }
}
