<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Slide;

class CreateSplitScreenRequest extends Request
{
    protected $slide;
    protected $rules = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!$this->has('hasBeenEdited') && !$this->hasFile('image')){
            return false;
        }
        return true;
    }
    public function forbiddenResponse()
    {
        dd('as');
        return \Redirect::to('presentations/' . $this->get('presentationId') . '/edit');
    }

    public function sanitize()
    {
        if ( !$this->hasFile('image')) {
            $input['image'] = null;
            $this->merge($input);
        }

        if(!$this->has('detachedImageId')){
            $this->merge(['detachedImageId'=>false]);
        }
        if(!$this->has('left')){
            $this->merge(['left'=>0]);
        }


        $input['use_presentation_color'] = $this->has('use_presentation_color') ? 1 :0;
        $this->merge($input);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $this->slide = Slide::find($this->slide_id);

        $this->addSlideIsFullRule();
        $this->addPositionEngagedRule();


        if ($this->type == 'text')
            $this->rules['text'] = 'required_without:image';
        else
            $this->addImageRule();

        return $this->rules;
    }

    public function messages()
    {
        return [
            'text.required_without'  => 'Text field is required',
            'image.required_without' => 'The image is required',
            'engaged.required'       => ($this->left ? 'Left' : 'Right') . ' position is already engaged',
            'full.required'          => 'Split screen can\'t have more than 2 items',
            'image.max_meg'          => 'The image size can\'t be more than 10 megabytes',
            'image.mimes'            => 'Wrong image extension, jpg,jpeg,bmp,png,gif allowed',
        ];
    }

    /**
     *  Adds new `full` rule if slide already has max number of items
     * */
    public function addSlideIsFullRule()
    {
        if ($this->slide->splits()->count() >= 2)
            $this->rules['full'] = 'required';
    }

    public function addPositionEngagedRule()
    {
        if ($this->slide->hasSplitInSection($this->left) && !array_key_exists('full', $this->rules))
            $this->rules['engaged'] = 'required';
    }

    public function addImageRule()
    {
        $this->rules['image'] = 'required_without:text|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';
    }
}
