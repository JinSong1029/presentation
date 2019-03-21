<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Slide;

class CreateTextRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( !$this->hasFile('image') && !$this->get('text'))
            return false;

        return true;
    }

    public function forbiddenResponse()
    {
        return \Redirect::to('presentations/' . $this->get('presentationId') . '/edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules['image'] = 'required|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';

        return $rules;
    }

    public function messages()
    {
        return [
            'image.required' => 'The image is required',
            'image.mimes'    => 'Wrong image extension, jpg,jpeg,bmp,png,gif allowed',
            'image.max_meg'    => 'The image size can\'t be more than 10 megabytes',
        ];
    }
}
