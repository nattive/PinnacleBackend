<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseActivityResource;
use App\Tutor;

class CourseActivityController extends Controller
{
    public function tutor()
    {
        $user = \auth()->user();
        $tutor = Tutor::where('id', $user->tutor -> id)->first();
        $CourseActivities = $tutor->courseActivities()->paginate(5);
        return CourseActivityResource::collection($CourseActivities);
    }
}
