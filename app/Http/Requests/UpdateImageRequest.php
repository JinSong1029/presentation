<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateImageRequest extends Request
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
        if($this->get('name')=='Image'){
            $input['logo'] = null;
        }
        if(!$this->hasFile('image')){
            $input['image'] = null;
        }
        $input['desc'] = null;
        $this->merge($input);

        $input['use_presentation_color'] = $this->has('use_presentation_color') ? 1 :0;
        $this->merge($input);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(!$this->get('name')){
            $rules['logoName'] = 'required';
        }
        if ($this->get('name') && $this->get('name')!='Image') {
            $rules['logo'] = 'required';
        }
        $rules['image'] = 'mimes:jpg,jpeg,bmp,png,gif|max_meg:10';
        return $rules;
    }

    public function messages()
    {
        return [
            'logo.required'  => 'Logo name field is required',
            'image.required' => 'The image is required',
            'image.mimes'    => 'Wrong image extension, jpg,jpeg,bmp,png,gif allowed',
            'logoName.required'=>'You need to specify the type - "Image" or "Client logo"',
            'image.max_meg'    => 'The image size can\'t be more than 10 megabytes',
        ];
    }
}
