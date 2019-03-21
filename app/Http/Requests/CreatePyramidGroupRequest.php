<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Slide;

class CreatePyramidGroupRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( !$this->get('content') && !$this->has('position') && !$this->get('title')) {
            return false;
        }

        return true;
    }

    public function sanitize()
    {
        if ( !$this->has('inside_triangle')) {
            $input['inside_triangle'] = 0;
            $this->merge($input);
        }
    }

    public function forbiddenResponse()
    {
        return response()->json([]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $engagedPositions = explode(',', $this->get('engagedPositions'));

        if (in_array((int)$this->get('position'), $engagedPositions) && $this->get('position'))
            $rules['position_filled'] = 'required';

        $slide                = Slide::where('id', '=', $this->get('slide_id'))->first();
        $groups               = $slide->slideables();
        $outsideTriangleCount = $groups->where('inside_triangle', 0)->count();
        $insideTriangleCount  = $groups->where('inside_triangle', 1)->count();

        if ($this->get('inside_triangle') && $insideTriangleCount >= 9) {
            $rules['insideOverload'] = 'required';
        } elseif ( !$this->get('inside_triangle') && $outsideTriangleCount >= 6) {
            $rules['outsideOverload'] = 'required';
        }

        $rules['title']           = 'max:50';
        $rules['content']         = 'required|max:525';
        $rules['inside_triangle'] = 'required';
        $rules['position']        = 'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'inside_triangle.required' => 'You must specify if group is inside the triangle',
            'insideOverload.required'  => 'Max count of items inside the triangle is 9',
            'outsideOverload.required' => 'Max count of items outside of the triangle is 6',
            'position_filled.required' => 'You chose the position that already in use',
        ];
    }
}
