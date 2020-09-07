<?php

namespace App\Http\Controllers;

use App\CourseDiscount;
use App\Http\Requests\CourseDiscountRequest;
use App\Http\Resources\CourseDiscountResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseDiscountController extends Controller
{
    public function index()
    {
        $tutor = auth()->user()->tutor;
     return CourseDiscountResource::collection($tutor -> CourseDiscounts);
    }

    public function store(CourseDiscountRequest $request)
    {
        $tutor = auth()->user()->tutor;
        $data = [
            'due' => Carbon::parse($request -> due)
        ];
        $tutor -> CourseDiscounts() -> create( array_merge($request ->validated(), $data) );
        return response()->json('Course discount has been created successfully', 200);
    }
}
