<?php

namespace App\Http\Resources;

use App\Course;
use App\CourseModule;
use Illuminate\Http\Resources\Json\JsonResource;

use function GuzzleHttp\json_decode;

class userCourseProgressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $modules = CourseModule::where('id', $this->module_id)-> first();
        $Course =  Course::where('id', $modules ->course_id)-> first();
        return [
            'course_name' => $Course -> title,
            'module_name' => $modules -> title,
            'user_id' => $this->user_id,
            'consumed_materials_array' => json_decode($this->consumed_materials_array),
            'total_course_material' => count($modules ->CourseMaterials),
            'finished' => $this-> finished,
        ];
    }
}
