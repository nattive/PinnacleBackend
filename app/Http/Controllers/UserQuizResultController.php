<?php

namespace App\Http\Controllers;

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
        $userQuizResult = UserQuizResult::where([['module_id', $request->module_id], ['user_id', auth('api')->user()->id]])->first();
        if ($userQuizResult) {
            return response()->json('You have taken this Quiz', 300);
        }
        $validate = $request->validate([
            'module_id' => 'required|int', //course material id, i.e relationship with course material,
            'no_correct_answer' => 'required|int',
            'no_wrong_answer' => 'required|int',
            // 'totalNumberOfQuestions' => 'required|int',
            'total' => 'required|int',
            'percentage' => 'required|int',
        ]);
        $array = ['user_course_progress' => 0];
        auth('api')->user()->userQuizResults()->create(array_merge($array, $validate));
        return response()->json('Course Progress Updated', 200);
    }
}
