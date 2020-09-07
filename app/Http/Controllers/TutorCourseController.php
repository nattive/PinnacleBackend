<?php

namespace App\Http\Controllers;

use App\Course;
use App\Tutor;

class TutorCourseController extends Controller
{
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with(['Modules.CourseMaterials', 'Reviews', 'users', 'SubCategory'])->first();
        return response()->json($course, 200);
    }

    public function myCourses($id)
    {
        $tutor = Tutor::where('id', $id)->first();
        $courses = $tutor->courses;
        return response()->json($courses, 200);
    }
}
