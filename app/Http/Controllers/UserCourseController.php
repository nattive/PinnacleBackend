<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Resources\CourseResource;
use App\SubCategory;
use App\User;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('getEnrolledCourse');
    }
    /**
     * 
     * This controller controls the user course
     * fetches all courses that are approves
     * enroll courses
     * show paid, and handle paid resource
     * 
     */

    public function show($slug)
    {
        $course = Course::where([['slug', $slug], ['isApproved', '=', 'true']])->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->first();
        return new CourseResource($course);
    }


    public function enroll(Request $request)
    {
        $v = $request->validate([
            'user_id' => 'required',
            'course_id' => 'required'
        ]);
        // return $v;
        $user = User::where('id', $request->user_id)->first();
        $course = Course::find($request->course_id);
        switch ($user->account_type) {
            case 'isPO':
                if ($course->isPO == 1) {
                    # code...
                    $user->courses()->sync($course, false);
                } else {
                    return response('course is for Pinnacle e-learning users', 401);
                }
                break;
            case 'isCareer':
                if ($course->isCareer == 1) {
                    # code...
                    $user->courses()->sync($course, false);
                } else {
                    return response('course is for careers of the future users', 401);
                }
                break;
            case 'isFree':
                if ($course->isFree == 1) {
                    # code...
                    $user->courses()->sync($course, false);
                } else {
                    return response('course is for careers of the future users');
                }
                break;

            default:
                if ($course->isFree == 1) {
                    # code...
                    $user->courses()->sync($course, false);
                }
                break;
        }
        $user->save();
        return response($user->courses);
    }

    public function play(Request $request)
    {
        $v = $request->validate([
            'user_id' => 'required',
            'course_id' => 'required'
        ]);
        // return $v;
        $user = User::where('id', $request->user_id)->first();
        $course = Course::where('id', $request->course_id)->with('Modules.CourseMaterials')->first();
        if ($user->courses->contains($request->course_id) == true) {
            return new CourseResource($course);
        } else {
            return response('Not Following', 402);
        }
    }

    public function checkIfEnrolled(Request $request)
    {
        // return $request -> all();
        $v = $request->validate([
            'user_id' => 'required',
            'course_id' => 'required',
        ]);
        // return $v;
        $user = User::where('id', $request->user_id)->first();
        if ($user) {
            if ($user->courses->contains(number_format($request->course_id)) == true) {
                return response('true');
            } else {
                return response('false');
            }
        }
        return response('unknown user', 404);
    }

    public function getEnrolledCourse()
    {
        // return $request-> all();
        // $v = $request->validate([
        //     'user_id' => 'required',
        // ]);
        // // return $v;
        // $user = User::where('id', $request->user_id)->first();
        return response(auth('api')->user()->courses);
    }


    public function get($number)
    {
        $courses = Course::where('isApproved', 'true')->with('tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 4);
        return CourseResource::collection($courses);
    }


    public function getPO($number)
    {
        $courses = Course::where('isPO', 1)->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
        return CourseResource::collection($courses);
    }


    public function getCOTF($number)
    {
        $courses = Course::where('isCareer', 1)->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
        return CourseResource::collection($courses);
    }


    public function getFREE($number)
    {
        $courses = Course::where('isFree', 'true')->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
        return CourseResource::collection($courses);
    }



    public function get_free_Career_courses($number)
    {
        $courses = Course::where([
            ['isPO', '=', 'true'],
            ['isFree', '=', 'true'],
        ])->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
        return CourseResource::collection($courses);
    }



    public function get_free_PO_courses($number)
    {
        $courses = Course::where([
            ['isPO', '=', 'true'],
            ['isFree', '=', 'true'],
        ])->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
        return CourseResource::collection($courses);
    }


    public function fetchByTutor($id)
    {
        $courses = Course::where('tutor_id', $id)->with('Modules.CourseMaterials', 'SubCategory')->get();
        return CourseResource::collection($courses);
    }


    public function get_paid_Career_courses($number)
    {
        $courses = Course::where([
            ['isCareer', '=', 'true'],
            ['isFree', '!=', 'true'],
        ])->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
        return CourseResource::collection($courses);
    }


    public function get_paid_PO_courses($number)
    {
        $courses = Course::where([
            ['isPO', '=', 'true'],
            ['isFree', '=', 'false'],
        ])->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
        return CourseResource::collection($courses);
    }

    public function getRecommendedCoursesByUser($id)
    {
        if ($id) {
            $user = User::findOrFail($id);
            if ($user) {
                $courses = $user->courses;
                $max = count($courses);
                $randomInt = $max >= 2 ? random_int(0, $max - 1) :  $max;
                $recommendedCourses = Course::where([['sub_category_id', $courses[$randomInt - 1]->sub_category_id], ['isPO', $courses[$randomInt - 1]->isPO]])->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate(6);
                return CourseResource::collection($recommendedCourses);
            }
        }
    }
}
