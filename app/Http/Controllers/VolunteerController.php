<?php

namespace App\Http\Controllers;

use App\Http\Requests\VolunteerRequest;
use App\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    /**
     * Store volunteer credential
     * User must be authenticated
     */
    public function store(VolunteerRequest $request)
    {
        Volunteer::create($request -> validated());
    }
}
