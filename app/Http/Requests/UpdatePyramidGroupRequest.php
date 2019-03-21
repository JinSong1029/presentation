<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Slide;

class UpdatePyramidGroupRequest extends Request
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
        $engagedPositions = explode(',', $this->get('engagedPositions'));

        $pyramid         = $this->route('pyramidGroups');
        $pyramidPosition = $pyramid->slides->first()->pivot->position;
        $position        = (int)$this->get('position');


        if (in_array($position, $engagedPositions) && $position != $pyramidPosition)
            $rules['position_filled'] = 'required';

        $slide                = Slide::where('id', $this->get('slide_id'))->first();
        $groups               = $slide->slideables();
        $outsideTriangleCount = $groups->where('inside_triangle', 0)->count();
        $insideTriangleCount  = $groups->where('inside_triangle', 1)->count();

        $inside = $this->get('inside_triangle');

        if ($inside && !$pyramid->inside_triangle && $insideTriangleCount >= 9) {
            $rules['insideOverload'] = 'required';
        } elseif ( !$inside && $pyramid->inside_triangle && $outsideTriangleCount >= 4) {
            $rules['outsideOverload'] = 'required';
        }

        $rules['title']           = 'max:50';
        $rules['content']         = 'required|max:525';
        $rules['inside_triangle'] = 'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'content.required'         => 'The comment field is required',
            'inside_triangle.required' => 'You must specify if group is inside the triangle',
            'insideOverload.required'  => 'Max count of items inside the triangle is 9',
            'outsideOverload.required' => 'Max count of items outside of the triangle is 4',
            'position_filled.required' => 'This position is in use, please select another',
        ];
    }
}
