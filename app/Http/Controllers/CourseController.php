<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Resources\CourseResource;
use App\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('tutor.user', 'Modules.CourseMaterials', 'SubCategory.MainCategory')->get();
        return CourseResource::collection($courses);
    }

    public function createCourseCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(100, 999)
        . mt_rand(10000, 99999)
            . $characters[rand(0, strlen($characters) - 1)]
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $string = str_shuffle($pin);
        $related = Course::select('CourseCode')->where('CourseCode', 'like', $string . '%')->get();
        if ($related) {
            return $string . '1';
        } else {
            return $string;
        }

        return $string;
    }

    public function createSlug($title)
    {
        // $code = $this->createCourseCode();
        // Normalize the title
        $slug = Str::slug($title);
        //CourseCode
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug);

        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }

        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        return response('can not create unique name', 500);
    }
    protected function getRelatedSlugs($slug)
    {
        return Course::select('slug')->where('slug', 'like', $slug . '%')->get();
    }

    protected function getRelatedCourseCode($CourseCode)
    {
        return Course::select('CourseCode')->where('CourseCode', 'like', $CourseCode . '%')->get();
    }

    public function uploadVideo($id, Request $request)
    {
        return $request->all();
        $course = Course::where('id', $id)->first();
        if ($request->file('file')) {
            $course->attachMedia($request->file('videoPath'));
            return response()->json('Iploaded Successfully', 200);
        }

    }

    public function basicCourseInfo(Request $request)
    {

        // return request()->all();
        $validateData = $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'courseType' => 'required',
            'isFree' => '',
            'prerequisite' => '',
            'duration' => '',
            'public_id' => 'requied',
            'price' => '',
            'sub_category_id' => 'required_if:courseType,isPO',
            'course_difficulty' => 'required',
            'career_category_id' => 'required_if:courseType,isCareer',
        ]);
        $code = $this->createCourseCode();
        $additionalData = [
            'courseCode' => $code,
            'slug' => $code . '-' . $this->createSlug(request('title')),
        ];
        $tutor = auth()->user()->tutor;
        // return $tutor -> courses;
        $tutor = Tutor::findOrFail($tutor->id);
        $course = $tutor->courses()
            ->create(array_merge($additionalData, $validateData));
        return response()->json($course, 200);
    }

    public function approve(Request $request, $id)
    {
        // return $request -> all();
        $course = Course::where('id', $id)->first();
        $course->isApproved = $request->isApproved;
        $course->ApprovedBy = $request->ApprovedBy;
        $course->save();
        return response('course has been Approved');
    }
// myCourses
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with('Modules.CourseMaterials','Reviews','users','SubCategory')->first();
        return response()->json($course, 200);
    }
    public function update(CourseUpdateRequest $request, $id)
    {
// auth()->user()->tutor()->courses()->update($request -> validated());
        $tutor = auth()->user()->tutor;
        $course = Course::findOrFail($id);
        if ($tutor->id == $course->tutor_id) {
            $course->update($request->validated());
            return response(['message' => 'course has been updated', 'status' => 200], 200);
        }
        return response('you don\'t have the required permission to update this course', 401);

    }

    public function destroy($id)
    {
        $course = Course::where('id', $id)->first();
        $course->delete();
        return response(['message' => 'course has been deleted', 'status' => 200], 200);
    }

    /**
     * Rate the course
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function Rating(Request $request)
    {
        $v = $request->validate([
            'rating' => 'required', // Course rating
            'id' => 'required', //Course id
        ]);

        $rate = number_format($request->rating); //80
        $Course = Course::find($request->id);
        $total_rating = number_format($Course->total_rating) + number_format($rate); //80
        $no_rated_user = $Course->no_rated_user + 1; //1
        $expected_rating = $no_rated_user * 100; //100
        $newRating = $total_rating * $expected_rating / 100; //80
        $Course->rating_percentage = $newRating;
        $Course->total_rating = $total_rating;
        $Course->save();
        $Course = Course::find($request->id);
        $total_rating = $Course->total_rating;
        return response($total_rating);
    }

}
