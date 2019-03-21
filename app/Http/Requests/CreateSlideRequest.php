<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSlideRequest extends Request
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
        if ($this->has('noMoreSlides') && $this->get('noMoreSlides')) {
            return [
                'lessSlides' => 'required',
            ];

        }

        return [
            'name'      => 'required',
            'slideType' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'lessSlides.required' => 'This section may have only one slide.',
            'name.required' => 'Slide name required.',
            'slideType.required' => 'Slide type required.',
        ];
    }
}
