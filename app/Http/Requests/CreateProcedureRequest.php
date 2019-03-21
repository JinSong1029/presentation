<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Slide;

class CreateProcedureRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( !$this->get('label') && !$this->get('desc'))
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
        $count = Slide::where('id', '=', $this->get('slide_id'))->first()->slideables()->count();
        if ($count >= 6)
            $rules['count'] = 'required';

        $rules['label'] = 'required';
        $rules['desc']  = 'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'label.required' => 'Label field is required',
            'desc.required'  => 'Description field is required',
            'count.required' => 'You can add only 6 items in this type of slide',
        ];
    }
}
