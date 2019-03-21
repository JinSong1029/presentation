<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Slide;

class CreateQuoteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( !$this->hasFile('image') && !$this->get('quote') && !$this->get('role') && !$this->get('author'))
            return false;

        return true;
    }

    public function forbiddenResponse()
    {
        return \Redirect::to('presentations/' . $this->get('presentationId') . '/edit');
    }

    public function sanitize()
    {
        if ($this->get('type') != 'image') {
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
        $slide   = Slide::where('id', '=', $this->get('slide_id'))->first();
        $slides  = $slide->slideables()->count();
        $doubles = $slide->slideables()->where('double', 1)->count();
        if ($this->get('double') && $slides >= 3)
            $rules['overload'] = 'required';
        if ($this->get('double') && $doubles >= 2)
            $rules['double'] = 'required';
        $count = $slide->slideables()->count();
        if ($count >= 4)
            $rules['count'] = 'required';
        if ($this->get('type') == 'image')
            $rules['image'] = 'required|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';
        else {
            $rules['author'] = 'max:255';
            $rules['role']   = 'max:255';
            $rules['quote']  = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'count.required'    => 'You can add only 4 items in this type of slide',
            'double.required'   => 'You can add only 2 double elements',
            'overload.required' => 'You can\'t make element "double" because you already have 3 or more elements',
            'image.max_meg'    => 'The image size can\'t be more than 10 megabytes',
        ];
    }
}
