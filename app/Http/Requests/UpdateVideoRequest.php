<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateVideoRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( !$this->hasFile('image') && !$this->get('url') && !$this->get('title'))
            return false;
        return true;
    }

    public function forbiddenResponse()
    {
        return \Redirect::to('presentations/' . $this->get('presentationId').'/edit');
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
        $video = $this->route()->parameter('videos');
        if ($video->image == null) {
            $rules['image'] = 'required|mimes:jpg,jpeg,bmp,png,gif';
        } else {
            $rules['image'] = 'mimes:jpg,jpeg,bmp,png,gif';
        }
        $rules['url']   = 'required|url';
        $rules['title'] = 'max:255';

        return $rules;
    }

    public function messages()
    {
        return [
            'image.required' => 'The image is required',
            'image.mimes'    => 'Wrong image extension, jpg,jpeg,bmp,png,gif allowed',
        ];
    }
}
