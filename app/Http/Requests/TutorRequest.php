<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TutorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'isCotF_tutor' => '',
            'isPO_tutor' => '',
            'rating' => 'nullable',
            'image' => '',
            'about' => '',
            'files' => '',
            'isAdmin' => '',
            'admin_id' => '',
            // 'user_id' => 'required',
            'facebook' => '',
            'twitter' => '',
            'linkedIn' => '',
            'youTube' => '',
        ];
    }
}
