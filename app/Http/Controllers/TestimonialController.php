<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        return Testimonial::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'userName' => 'required|string',
            'userTitle' => '',
            'position' => 'required|string',
            'body' => 'required|string|max:500',
        ]);
        Testimonial::create($data);
        return response()->json('Testimonial saved successfully', 200);
    }

    public function show($location)
    {
        $testimony = Testimonial::where("position", $location)->get();
        return response()->json($testimony, 200);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial -> delete();
        return response()->json('Deleted succesfully', 200);
    }
}
