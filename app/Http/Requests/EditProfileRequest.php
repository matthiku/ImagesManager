<?php

namespace ImagesManager\Http\Requests;

use ImagesManager\Http\Requests\Request;

class EditProfileRequest extends Request
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
        return 
        [
            // validation
            'name'     => 'required',
            'password' => 'confirmed|min:6',
            'question' => 'required_with:answer',
            'answer'   => 'confirmed',
        ];
    }
}
