<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenteeRequest;
use Illuminate\Http\Request;

class MenteeController extends Controller
{
    public function store(MenteeRequest $request)
    {
        auth()->user()->mentee()->create($request ->validated());
        return 'Created';
    }
}
