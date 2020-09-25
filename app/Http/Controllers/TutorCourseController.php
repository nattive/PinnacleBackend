<?php

namespace App\Http\Controllers;

use App\Course;
use App\Tutor;

class TutorCourseController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with(['Modules.CourseMaterials', 'Reviews', 'users', 'SubCategory'])->first();
        return response()->json($course, 200);
    }

    public function myCourses()
    {
        // $tutor = Tutor::where('id', $id)->first();
        $tutor = auth()->user()->tutor;
        $courses =Course::where('tutor_id', $tutor -> id)->get();

        return response()->json($courses, 200);
    }
}
