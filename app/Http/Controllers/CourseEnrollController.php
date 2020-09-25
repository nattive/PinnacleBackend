<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Resources\CourseResource;
use App\userCourseProgress;
use Illuminate\Http\Request;

class CourseEnrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(CourseResource::collection(auth('api')->user()->courses));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = $request->validate([
            'course_id' => 'required',
        ]);
// return $v;
        $user = auth()->user();
        $course = Course::findOrFail($request->course_id);
        $totalModules = 0;
        /**
         * Loop through course modules to get total number of material
         */

        if ($course->Modules) {
            foreach ($course->Modules as $module) {
                $totalModules += count($module->CourseMaterials);
            }
        }
        if ($user->account_type == $course->courseType) {
            $user->courses()->sync($course, false);
            userCourseProgress::findOrNew([
                'course_id' => $course->id,
                'total_module' => $totalModules,
                'user_id' =>  $user ->id,
            ]);

            //

        } else {
            return response()->json('This course is not meant for you', 401);
        }
        $user->save();
        return response()->json('Course Enrolled successfully', 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
