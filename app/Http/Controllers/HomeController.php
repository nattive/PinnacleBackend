<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseMaterials;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('Pages.admin');
    }
    public function courses()
    {
        return view('Pages.courses');
    }
    public function addCourse()
    {
        return view('Pages.addCourse');
    }
     public function blog()
    {
        return view('Pages.blog');
    }
 public function testimonial()
    {
        return view('Pages.testimonial');
    }

    public function category()
    {
        return view('Pages.Category');
    }
    public function AllCourses()
    {
        return view('Pages.AllCourses');
    }
    public function AddQuestion($id)
    {
        $material = CourseMaterials::find($id);
        // return $material;
        return view('Pages.addQuestion', compact('material'));
    }
    public function courseModuleList($id)
    {
        $materials = Course::where('id', $id)->with('Modules.CourseMaterials')->first();
        return view('Pages.courseModuleList', compact('materials'));
    }

    public function modules($id)
    {
        $course = Course::where('id', $id)->first();
        return view('Pages.modules', compact('course'));
    }

    public function updateCourse($course)
    {
        $course = Course::find($course);
        return view('Pages.editCourse', compact('course'));
    }
}
