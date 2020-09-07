<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function getAdmin()
    {
        dd(Auth::user());
        if (Auth::user()) {

            return json_encode(User::with('tutor')->where('id', Auth::user()->id))->first();
        } else {
            return 'unauthorized';
        }
    }
}
