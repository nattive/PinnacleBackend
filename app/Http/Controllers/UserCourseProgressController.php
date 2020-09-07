<?php

namespace App\Http\Controllers;

use App\Http\Resources\userCourseProgressResource;
use App\userCourseProgress;
use Illuminate\Http\Request;

class UserCourseProgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \auth('api')->user();
        if ($user) {
            $userCourseProgress = userCourseProgress::where('user_id', $user->id)->get();
            return userCourseProgressResource::collection($userCourseProgress);
        }
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\userCourseProgress  $userCourseProgress
     * @return \Illuminate\Http\Response
     */
    public function show(userCourseProgress $userCourseProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\userCourseProgress  $userCourseProgress
     * @return \Illuminate\Http\Response
     */
    public function edit(userCourseProgress $userCourseProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\userCourseProgress  $userCourseProgress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, userCourseProgress $userCourseProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\userCourseProgress  $userCourseProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(userCourseProgress $userCourseProgress)
    {
        //
    }
}
