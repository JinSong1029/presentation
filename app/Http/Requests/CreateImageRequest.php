<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateImageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( !$this->hasFile('image') && !$this->get('logo'))
            return false;

        return true;
    }

    public function forbiddenResponse()
    {
        return \Redirect::to('presentations/' . $this->get('presentationId') . '/edit');
    }

    public function sanitize()
    {
        if ($this->get('name') == 'Image') {
            $input['logo'] = null;
        }
        $input['desc'] = null;
        $this->merge($input);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ( !$this->has('desc')) {
            $input['desc'] = null;
            $this->merge($input);
        }
        if ( !$this->has('logo')) {
            $input['logo'] = null;
            $this->merge($input);
        }

        if($this->singular>=1){
            $rules['overload'] = 'required';
        }
        if ( !$this->get('name')) {
            $rules['logoName'] = 'required';
        }
        if ($this->get('name') && $this->get('name') != 'Image') {
            $rules['logo'] = 'required';
        }
        $rules['image'] = 'required|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';

        return $rules;
    }

    public function messages()
    {

        return [
            'logo.required'     => 'Logo name field is required',
            'image.required'    => 'The image is required',
            'image.max_meg'     => 'The image size can\'t be more than 10 megabytes',
            'image.mimes'       => 'Wrong image extension, jpg,jpeg,bmp,png,gif allowed',
            'logoName.required' => 'You need to specify the type - "Image" or "Client logo"',
            'overload.required' => 'You can\'t add more than one picture',

        ];
    }
}
