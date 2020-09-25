<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseModule;
use Illuminate\Http\Request;

class CourseModules extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $module = Course::where('id', $id)->with('Modules')->first()->modules;
        return response(['module' => $module]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required',
                // 'title' => 'required|unique:courses',
                'course_id' => 'required',
            ]);

            CourseModule::create($data);
            return response('Module Added');
        } catch (\Throwable $th) {
            return response(json_encode($th), 500);
        }
    }

    /**
     * Display the course module for a specific course
     *
     * @param  int Course $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = CourseModule::find($id)->with('course', 'CourseMaterials.CourseQuestions')->first();
        return response()->json($module, 200);
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
            'title' => 'required',
        ]);

        $CourseModule = CourseModule::findOrFail($id);
        $CourseModule->update($data);
        // return json_encode( $CourseModule) ;
        return response('Module updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
