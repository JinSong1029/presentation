<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateTeamRequest extends Request
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

    public function sanitize()
    {
        if ( !$this->hasFile('image')) {
            $input['image'] = null;
            $this->merge($input);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'mimes:jpg,jpeg,bmp,png,gif|max_meg:10',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'The image is required',
            'image.mimes'    => 'Wrong image extension, jpg,jpeg,bmp,png,gif allowed',
            'image.max_meg'  => 'The image size can\'t be more than 10 megabytes',
        ];
    }
}
