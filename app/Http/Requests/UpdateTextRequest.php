<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateTextRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->get('text'))
            return false;

        return true;
    }
    public function forbiddenResponse()
    {
        return \Redirect::to('presentations/' . $this->get('presentationId').'/edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'text'=>'required'
        ];
    }
}
