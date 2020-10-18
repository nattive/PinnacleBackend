<?php

namespace App\Http\Controllers;

use App\userMessage;
use Illuminate\Http\Request;

class UserMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function send(Request $request)
    {
        $messageData = $request->validate([
            'From' => 'required',
            'Subject' => 'required',
            'body' => 'required',
        ]);
        userMessage::create($messageData);
        return response()->json('Message Sent', 200);
    }
}
