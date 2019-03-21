<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateSplitScreenRequest extends CreateSplitScreenRequest
{

    public function authorize()
    {
        return true;
    }

    public function addSlideIsFullRule()
    {
        return;
    }

    public function addPositionEngagedRule()
    {
        if ($this->left == $this->route('splits')->left)
            return;
    }

    public function addImageRule()
    {
        if ($this->route('splits')->image && !$this->hasFile('image'))
            return;
        else {
            $this->rules['image'] = 'required_without:text|mimes:jpg,jpeg,bmp,png,gif|max_meg:10';
        }
    }
}
