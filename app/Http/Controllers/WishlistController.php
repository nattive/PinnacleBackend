<?php

namespace App\Http\Controllers;

use App\wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        return auth()->user()->wishlists;
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required',
        ]);
        auth()->user()->wishlists()->create($data);
        return response()->json('Added to wish list', 200);
    }

    public function destroy(wishlist $wishlist)
    {
        $wishlist -> delete();
        return response()->json('deleted', 200);
    }
}
