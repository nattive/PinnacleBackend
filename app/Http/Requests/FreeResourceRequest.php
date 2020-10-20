<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreeResourceRequest extends FormRequest
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
            'subtitle' => '',
            'banner' => 'required',
            'resource_category_id' => 'required',
            'body' => 'required',
            'filename' => '',
            'mediaType' => '',
            'mediaCaption' => '',
            'file' => '',
        ];
    }
}
