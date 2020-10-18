<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Support\Facades\Auth;

class CourseCartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get all items in cart
     * @return Response
     */

    public function index()
    {
        $user = auth()->user();
        $cart = $user->courseCart;
        return response()->json($cart, 200);
    }

    /**
     *
     * Add Course to cart
     * @param Course $id
     * @return Response
     *
     */
    public function store($id)
    {
        //  foreach ($user->courseCart()->courseCartItems as $cartItem) {
        //      $total += $cartItem -> course() -> price ?? 0;
        //   }
        $total = 0;
        $cart = [];
        $user = auth()->user();
        $course = Course::findOrFail($id);
        if ($user->account_type == $course->courseType) {
            if ($user->courseCart) {
                $cart = $user->courseCart();
                $cart->update([
                    'total' => $user->courseCart->total += $course->price ?? 0,
                ]);
            } else {
                $cart = auth()->user()->courseCart()->create([
                    'total' => $course->price ?? 0,
                ]);
            }
            $cart->courseCartItems()->sync($course, false);
            return response()->json('Cart added', 200);
        }
        return response()->json('you are not eligible for this course', 401);
    }

}
