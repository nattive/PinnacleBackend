<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentLibraryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'slug' => $this->slug,
            'banner' => $this->banner,
            'subtitle' => $this->subtitle,
            'body' => $this->body,
            'admin' => $this->admin,
            'user' => $this->user,
            'mediaFiles' => $this->mediaFiles,
            'category' => $this->category,
            'by' => $this-> admin -> name ?? $this-> user -> name ?? [],
            'created' => Carbon::parse($this-> created_at)->toDateTimeLocalString()
        ];
    }
}
