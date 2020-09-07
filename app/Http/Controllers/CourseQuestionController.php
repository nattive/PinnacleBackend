<?php

namespace App\Http\Controllers;

use App\CourseQuestion;
use Illuminate\Http\Request;

class CourseQuestionController extends Controller
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
    public function store(Request $request)
    {
        // return $request->all();
        $validate = $request->validate([
            'course_materials_id' => 'required',
            'question' => 'required|max:250',
            'optionA' => 'required|max:250',
            'optionB' => 'required|max:250',
            'optionC' => 'required|max:250',
            'optionD' => 'required|max:250',
            'answer' => 'required|max:250',
        ]);

        CourseQuestion::create($validate);
        return response()->json('Question added successfully', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseQuestion  $courseQuestion
     * @return \Illuminate\Http\Response
     */
    public function show($courseQuestion)
    {
        $questions = CourseQuestion::find($courseQuestion);
        return response()->json($questions, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseQuestion  $courseQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseQuestion $courseQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseQuestion  $courseQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseQuestion $courseQuestion)
    {
        $validate = $request->validate([
            'course_materials_id' => 'nullable',
            'question' => 'nullable|max:250',
            'optionA' => 'nullable|max:250',
            'optionB' => 'nullable|max:250',
            'optionC' => 'nullable|max:250',
            'optionD' => 'nullable|max:250',
            'answer' => 'nullable|max:250',
        ]);
        $data = array_filter($request->validated());
        $courseQuestion->update();
        return response()->json('Course updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseQuestion  $courseQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseQuestion $courseQuestion)
    {
        //
    }
}
