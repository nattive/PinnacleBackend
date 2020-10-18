<?php

namespace App\Http\Resources;

use App\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $next = BlogPost::where('id', $this-> id +1)->first();
        $last = BlogPost::where('id', $this-> id -1)->first();
        return [
            'id' => $this->id,
            'tags' => $this->tags,
            'imageUrl' => $this->imageUrl,
            'mediaType' => $this->mediaType,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'comments' => CommentResource::collection($this->comments),
            'created' => Carbon::parse($this-> created_at)->toFormattedDateString(),
            'next' => $next ?? [],
            'last' => $last ?? [],
        ];
    }
}
