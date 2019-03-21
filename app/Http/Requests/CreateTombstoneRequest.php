<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Slide;

class CreateTombstoneRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( !$this->hasFile('image') && !$this->get('label')) //  && !$this->get('desc')
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
        $slide = Slide::where('id', '=', $this->get('slide_id'))->first();
        $count = $slide->slideables()->count();
        if ($count >= 6)
            $rules['count'] = 'required';

        $rules['image'] = 'required|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';

        return $rules;
    }

    public function messages()
    {
        return [
            'image.required' => 'The image is required',
            'image.mimes'    => 'Wrong image extension, jpg,jpeg,bmp,png,gif allowed',
            'count.required' => 'You can add only 6 items in this type of slide',
            'image.max_meg'    => 'The image size can\'t be more than 10 megabytes',
        ];
    }
}
