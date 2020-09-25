<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseMaterialRequest extends FormRequest
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
            'title' => 'required',
            'course_module_id' => 'required',
            'stepInModule' => 'nullable',
            'text' => '',
            'quiz' => 'nullable',
            'objective' => 'nullable',
            'prerequisite' => 'nullable',
            'videoPath' => 'nullable',
            'images' => 'nullable',
            'duration' => 'nullable',
            'public_id' => 'nullable',
        ];
    }
}
