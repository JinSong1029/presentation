<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Slide;

class CreateGallaryRequest extends Request
{

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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
        $slide = Slide::where('id', '=', $this->get('slide_id'))->first();
        $count = $slide->slideables()->count();
        if ($count >= 6)
            $rules['count'] = 'required';

        $rules['image'] = 'required|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';
        $rules['image2'] = 'required|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';

        if($this->double) {
            $rules['image3'] = 'required|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';
            $rules['image4'] = 'required|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';
        }

        $rules['label'] = 'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'image.required' => 'The image 1 is required',
            'image.mimes'    => 'Wrong image 1 extension, jpg,jpeg,bmp,png,gif allowed',
            'count.required' => 'You can add only 6 items in this type of slide',
            'image.max_meg'    => 'The image 1 size can\'t be more than 10 megabytes',

            'image2.required' => 'The image 2 is required',
            'image2.mimes'    => 'Wrong image 2 extension, jpg,jpeg,bmp,png,gif allowed',
            'image2.max_meg'    => 'The image 2 size can\'t be more than 10 megabytes',
            'image3.required' => 'The image 3 is required',
            'image3.mimes'    => 'Wrong image 3 extension, jpg,jpeg,bmp,png,gif allowed',
            'image3.max_meg'    => 'The image 3 size can\'t be more than 10 megabytes',
            'image4.required' => 'The image 4 is required',
            'image4.mimes'    => 'Wrong image 4 extension, jpg,jpeg,bmp,png,gif allowed',
            'image4.max_meg'    => 'The image 4 size can\'t be more than 10 megabytes',
            
            'label.required' => 'Heading required',
        ];
    }
}
