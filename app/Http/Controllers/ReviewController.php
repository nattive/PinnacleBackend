<?php

namespace App\Http\Controllers;

use App\Course;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Course $id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'review' => 'required|max:250',
            'rating' => 'required',
            'user_name' => 'required|max:250',
            'user_id' => 'required',
            'course_id' => 'required',
        ]);
        // return $data;
        Review::create($data);

        return response('review created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $course = Course::find($id);
        $review = Review::where('course_id', $id)->latest()->paginate(5);
        // $reviews = $course->Reviews->take(10);
        return json_encode($review);
    }

    public function check(Request $request)
    {
        $data = $request->validate(
            [
                'userId' => 'required',
                'reviewId' => 'required'
            ]
        );
// return $data;
        $user = User::where('id', $request->userId)->first();
        if ($user->Reviews->contains($request->reviewId) == true) {
            return 'true';
        } else {
            return 'false';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $request = Review::findOrFail($id);
        $request -> delete();
        return response('Deleted');
    }
}
