<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateKeyRequest extends Request
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

        $rules = [];
        if (!$this->has('random')) {
            $rules['key'] = 'required|alpha_num|min:3|max:16';
        }
        return $rules;
    }
}
