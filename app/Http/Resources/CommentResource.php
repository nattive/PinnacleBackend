<?php

namespace App\Http\Resources;

use App\Comment;
use App\Reply;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $replies = Reply::where('comment_id', $this->id)->with('user')->get();
        return [
            'id' => $this-> id,
            'body' => $this-> body,
            'replies' => $replies,
            'user' => $this-> user,
            'date' => Carbon::parse($this-> created_at)->diffForHumans(),
        ];
    }
}
