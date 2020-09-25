<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Course;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $course = Course::findOrfail($id);
        return response()->json(CommentResource::collection($course -> Comments()->paginate(8)), 200);
    }

    /**
     * Store a comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        auth()->user()->Comments() -> create($request->validated());
        return response()->json('Comment Sent', 200);
    }

    /**
     * Update the comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());
        return response()->json('Comment Updated', 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json('Comment Deleted', 200);

    }
}
