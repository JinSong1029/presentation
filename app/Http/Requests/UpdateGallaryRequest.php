<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateGallaryRequest extends Request
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
        if ( !$this->hasFile('image2')) {
            $input['image2'] = null;
            $this->merge($input);
        }
        if ( !$this->hasFile('image3')) {
            $input['image3'] = null;
            $this->merge($input);
        }
        if ( !$this->hasFile('image4')) {
            $input['image4'] = null;
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
        $gallery = $this->route('gallarys');

        $rules = [
            'label' => 'required',
        ];

        //if there's no 3d there's also no 4th as both are required on create
        if ( !$gallery->image3 && $this->double){
            $rules['image3'] = 'required';
            $rules['image4'] = 'required';
        }

        return $rules;

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
