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
//         course_id
// user_id
// progress
// module_id
        $modules =  $this->module_id ? CourseModule::where('id', $this->module_id)-> first() : '';
        $Course =  $this ->course_id ?  Course::where('id', $this ->course_id)-> first(): '';
        return [
            'course_name' => $Course -> title,
            'modules' => $modules,
            'user_id' => $this->user_id,
            'consumed_materials_array' =>$this->consumed_materials_array ? json_decode($this->consumed_materials_array) : [],
            'total_course_material' => $modules ?  count($modules ->CourseMaterials) : 0,
            'finished' => $this-> finished,
        ];
    }
}
