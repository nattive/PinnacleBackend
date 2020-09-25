<?php

namespace App\Http\Resources;

use App\CourseModule;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $materials = 0;
        $modules = CourseModule::where('course_id', $this->id)->get();
        if ($modules) {
          foreach ($modules as $module) {
             $materials += count($module->CourseMaterials);
          }
        }
        return [
            'title' => $this-> title,
            'id' => $this-> id,
            'subtitle' =>  $this->subtitle,
            'courseCode' =>  $this->courseCode,
            'videoUrl' =>  $this->videoUrl,
            'image_public_id' =>  $this->image_public_id,
            'video_public_id' =>  $this->video_public_id,
            'sub_category_id' =>  $this->sub_category_id,
            'banner' =>  $this->banner,
            'courseType' =>  $this->courseType,
            // 'career_category_id' =>  $this->career_category_id,
            'isFree' =>  $this->isFree,
            'no_rated_user' =>  $this->no_rated_user,
            'rating_percentage' =>  $this->rating_percentage,
            'total_rating' =>  $this->total_rating,
            'price' =>  $this->price,
            'objective' =>  $this->objective,
            'tutor_id' =>  $this->tutor_id,
            'slug' =>  $this->slug,
            'course_difficulty' =>  $this->course_difficulty,
            'description' =>  $this->description,
            'prerequisite' =>  $this->prerequisite,
            'duration' =>  $this->duration,
            'tutor' =>  $this->tutor,
            'Modules' =>  $this->Modules() -> with('CourseMaterials.CourseQuestions')->get(),
            'Reviews' =>  $this->Reviews,
            'users' =>  $this->users,
            'total_materials' => $materials,
            'SubCategory' =>  $this->SubCategory,
            'CareerCategory' =>  $this->CareerCategory,
            'Comments' =>  $this->Comments,
            'updated' => Carbon::parse($this -> updated_at)->diffForHumans(),

        ];
    }
}
