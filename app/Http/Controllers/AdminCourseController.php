<?php

namespace App\Http\Controllers;

use App\Course;

class AdminCourseController extends Controller
{
    public function courses()
    {
      $courses = Course::with('tutor.user', 'Modules.CourseMaterials', 'SubCategory.MainCategory')->get();
        return response()->json($courses, 200);
    }

}
