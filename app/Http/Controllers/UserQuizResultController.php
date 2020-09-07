<?php

namespace App\Http\Controllers;

use App\CourseMaterials;
use App\userCourseProgress;
use App\UserQuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserQuizResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function store(Request $request)
    {
        // return auth('api')->user();
        if (auth('api')->user()->id) {
            $validate = $request->validate([
                'module_id' => 'required|int', //course material id, i.e relationship with course material,
                'no_correct_answer' => 'required|int',
                'no_wrong_answer' => 'required|int',
                // 'totalNumberOfQuestions' => 'required|int',
                'total' => 'required|int',
                'percentage' => 'required|int',
            ]);
            $array = ['user_id' => auth('api')->user()->id, 'user_course_progress' => 0];
            UserQuizResult::create(array_merge($array, $validate));
            $CourseMaterials = CourseMaterials::where('id', $request->module_id)->with('Module')->first(); // The Quiz course Material
            // return  $CourseMaterials;
            $userCourseProgress = userCourseProgress::where('course_id', $CourseMaterials->module->course->id)->first();
            // return ['CourseMaterials' => $CourseMaterials, 'userCourseProgress' => $userCourseProgress ];
            if ($userCourseProgress) {
                /**
                 * Add  to taken module array
                 */
                // $consumed_materials = json_decode($userCourseProgress->consumed_materials);
                // $newConsumedMaterial = array($CourseMaterials->module->title => $CourseMaterials->module->id);
                // $userCourseProgress->consumed_materials_array = \json_encode($newConsumedMaterial);
                // $userCourseProgress->finished = false;
                // $userCourseProgress->save();
                return response()->json('you have taken this quiz', 200);
            }
            $consumed_materials = json_encode(array($CourseMaterials->module->title => $CourseMaterials->module->id));
            userCourseProgress::create([
                'course_id' => $CourseMaterials->module->course->id,
                'module_id' => $CourseMaterials->module->id,
                'user_id' =>  auth('api')->user()->id,
                'consumed_materials_array' => $consumed_materials,
                'finished' => count($CourseMaterials->module->CourseMaterials) <= 1  ? true : false
            ]);
            return response()->json('Course Progress Updated', 200);
        } else {
            return response()->json('Please Sign in', 401);
        }
    }
}
