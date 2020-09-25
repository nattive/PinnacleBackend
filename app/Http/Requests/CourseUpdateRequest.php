<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'isApproved' => 'nullable',
            'ApprovedBy' => 'nullable',
            'courseCode' => 'nullable',
            'videoUrl' => 'nullable',
            'sub_category_id' => 'nullable',
            'banner' => 'nullable',
            'courseType' => 'nullable',
            'career_category_id' => 'nullable',
            'isFree' => 'nullable',
            'image_public_id' => 'nullable',
            'video_public_id' => 'nullable',
            'no_rated_user' => 'nullable',
            'rating_percentage' => 'nullable',
            'total_rating' => 'nullable',
            'comment_id' => 'nullable',
            'price' => 'nullable',
            'objective' => 'nullable',
            'course_difficulty' => 'nullable',
            'description' => 'nullable',
        ];
    }
}
