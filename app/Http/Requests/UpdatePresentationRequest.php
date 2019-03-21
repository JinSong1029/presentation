<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePresentationRequest extends Request
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
        if(!$this->hasFile('image')){
            $input['image']  = null;
            $this->merge($input);
        }
        if(!$this->hasFile('background')){
            $input['background']  = null;
            $this->merge($input);
        }
        if($this->has('new-image')){
            $input['new']  = $this->get('new-image') == 'false' ? 0 : 1;
            $this->merge($input);
        }
        if($this->has('new-background')){
            $input['new']  = $this->get('new-background') == 'false' ? 0 : 1;
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
        return [
            'client'=>'required',
            'title'=>'required',
            'image'  => 'mimes:jpg,jpeg,bmp,png,gif|max_meg:10',
            'red'    => 'integer|required_with:green,blue',
            'green'  => 'integer|required_with:red,blue',
            'blue'   => 'integer|required_with:red,green',
        ];
    }
    public function messages()
    {

        return [
            'image.max_meg' => 'The image size can\'t be more than 10 megabytes',
            'image.mimes'   => 'Wrong image extension, jpg,jpeg,bmp,png,gif allowed',
            'green.required_with' => 'You should specify green.',
            'red.required_with'   => 'You should specify red.',
            'blue.required_with'  => 'You should specify blue.',
            'green.integer'       => 'Green color should be a digit.',
            'red.integer'         => 'Red color should be a digit.',
            'blue.integer'        => 'Blue color should be a digit.',
        ];
    }
}
