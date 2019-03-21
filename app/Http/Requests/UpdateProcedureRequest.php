<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateProcedureRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => 'required',
            'desc'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'label.required' => 'Label field is required',
            'desc.required'  => 'Description field is required',
        ];
    }
}
