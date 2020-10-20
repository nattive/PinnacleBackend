<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Resources\CourseResource;
use App\User;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['getEnrolledCourse', 'play']);
    }
    /**
     *
     * This controller controls the user course
     * fetches all courses that are approves
     * enroll courses
     * show paid, and handle paid resourceapi
     *
     */

    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->first();
        // return $course;
        // $course = Course::where([['slug', $slug], ['ApprovedBy', '!=', nulltrue']])->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->first();
        return new CourseResource($course);
    }

    public function recommendations(Request $request)
    {
        if ($request->slugArray) {
            $max = count($request->slugArray);
            if ($max == 1) {
                $course = Course::where('slug', $request->slugArray[0])->first();
                $RecommendedCourses = Course::where([['sub_category_id', $course->sub_category_id],
                    ['career_category_id', $request->career_category_id]])->get();
                $data = [
                    'Title' => $course->title,
                    'Course' => CourseResource::collection($RecommendedCourses),
                ];
                return response()->json($data, 200);
            }
            $randomInt = rand(0, $max);
            $course = Course::where('slug', $request->slugArray[$randomInt])->first();
            $RecommendedCourses = Course::where([['sub_category_id', $course->sub_category_id],
                ['career_category_id', $request->career_category_id]])->get();
            $data = [
                'Title' => $course->title,
                'Course' => CourseResource::collection($RecommendedCourses),
            ];
            return response()->json($data, 200);

        }
        return $request->slugArray;
    }
    public function play($slug)
    {
        $user = auth()->user();
        $course = Course::where('slug', $slug)->first();
        if ($user->courses->contains($course) == true) {
            return new CourseResource($course);
        } else {
            return response('Not Following', 401);
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


    /**
     *  Get courses related to user's account
     * @return Response
     *
     **/
public function topRated()
{
    $user = auth()->user;
    $courses = Course::where('courseType', $user -> account_type)->get();
    return response()->json(CourseResource::collection( $courses), 200);
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
        $courses = Course::where('ApprovedBy', '!=', null)->with('tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 4);
        return CourseResource::collection($courses);
    }

    public function getPO($number)
    {
        $courses = Course::where('courseType', 'isPO')->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
        return CourseResource::collection($courses);
    }

    public function getCOTF($number)
    {
        $courses = Course::where('courseType','isCareer')->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate($number ?? 5);
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
                $randomInt = $max >= 2 ? random_int(0, $max - 1) : $max;
                $recommendedCourses = Course::where([['sub_category_id', $courses[$randomInt - 1]->sub_category_id], ['isPO', $courses[$randomInt - 1]->isPO]])->with('Reviews', 'tutor', 'Modules.CourseMaterials', 'SubCategory')->paginate(6);
                return CourseResource::collection($recommendedCourses);
            }
        }
    }
}
