<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CheckKeyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return $this->route('presentations')->key == $this->get('key');

    }

    public function forbiddenResponse()
    {
        return redirect()->back()->with('error', 'Specified key is not valid');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
