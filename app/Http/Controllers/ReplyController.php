<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'comment_id' => 'required',
            'body' => 'required',
        ]);
        $extraData = [
            'user_id' => auth()->user()-> id
        ];
        $Comment = Comment::findOrFail(request('comment_id'));
        $Comment->replies()->create(array_merge($data, $extraData));
        return response()->json('Replied', 200);
    }
    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);
        $reply->delete();
        return response()->json('Deleted', 200);

    }
}
