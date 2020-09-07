<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDiscountResource extends JsonResource
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
            'name' => $this->name,
            // 'banner',
            'type' => $this->type,
            'due' => Carbon::parse($this->due),
            'code' => $this->code,
            'active' => !Carbon::parse($this->due)->isPast(),
            // 'users' => $this->users,
            'discount' => $this->discount,
        ];
    }
}
