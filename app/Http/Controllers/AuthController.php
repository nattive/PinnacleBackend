<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth:api')->only('me');

    }
    public function register(Request $request)
    {
        // return $request;
        $v = $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'name' => 'required',
            'account_type' => 'required',
        ]);

        $user = User::create($v);

        $token = auth('api')->login($user);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email/Password incorrect'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        $user =  auth('api')->user();
        return response()->json([
            'user' => $user,
            'tutor' =>$user->tutor,
            'courses' => auth('api')->user()->courses ?? '',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60000,
        ]);
    }

    public function me()
    {
        $user = auth()->user();
        if ( auth()->user()->tutor()->exists()) {
            $tutor = auth()->user()->tutor;
            # code...
            // $tutor = $user->tutor ;
            return response()->json(compact('user', 'tutor'));
        }
        return response()->json(compact('user'));

    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return auth('api')->guard();
    }
}
