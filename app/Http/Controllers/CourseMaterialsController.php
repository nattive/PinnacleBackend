<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseMaterials;
use Illuminate\Http\Request;
use App\Http\Requests\CourseMaterialRequest;
class CourseMaterialsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $course = Course::where('id', $id)->first();
        return view('Pages.modules', compact('course'));
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
     * Store the incoming blog post.
     *
     * @param  CourseMaterialRequest  $request
     * @return Response
     */

    public function store(CourseMaterialRequest $request)
    {
        // return $request->validated();
        CourseMaterials::create($request->only([
            'title',
            'course_module_id',
            'stepInModule',
            'text',
            'quiz',
            'objective',
            'prerequisite',
            'videoPath',
            'images',
        ]));
        return response('Module has been uploaded', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseMaterials  $courseMaterials
     * @return \Illuminate\Http\Response
     */
    public function show($courseMaterials)
    {
        $CourseMaterial = CourseMaterials::where('id', $courseMaterials)->with('Module', 'CourseQuestions')->first();
        return response()->json($CourseMaterial, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseMaterials  $courseMaterials
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseMaterials $courseMaterials)
    {
        dd($courseMaterials);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseMaterials  $courseMaterials
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseMaterials $courseMaterials)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseMaterials  $courseMaterials
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseMaterials $courseMaterials)
    {
        //
    }
}
