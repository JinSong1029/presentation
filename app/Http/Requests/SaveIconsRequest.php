<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaveIconsRequest extends Request
{
    private $logos;

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
        $logos = $this->get('logos');
//        dd($this->all());
        $count = count($logos);

        for ($i = 1; $i <= $count; $i++) {
            if ($logos[$i]['new-image'] == 'false' && $logos[$i]['new-title'] == 'false'&& $logos[$i]['detachedLogoId'] == '') {
                array_forget($logos, $i);

            } else {
                array_forget($logos[$i], 'new-image');
                array_forget($logos[$i], 'new-title');
                $logos[$i]['position'] = $i;
                if ($this->hasFile('logos.' . $i . '.image')) {
                    $logos[$i]['image'] = $this->file('logos.' . $i . '.image');
                } else {
                    $logos[$i]['image'] = null;
                }
            }
        }
        $input['logos'] = $logos;
        $this->logos    = $input['logos'];
        $this->merge($input);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd($this->logos);
//        dd($this->get('logos.0'));
        $count = count($this->logos);
        $rules = [];

        foreach ($this->logos as $logo) {
            if ( !$logo['attachedLogoId'] && !$logo['detachedLogoId']) {
                if ( !array_key_exists('id', $logo))
                    $rules['logos.' . $logo['position'] . '.image'] = 'required';
                if ($this->hasFile('logos.' . $logo['position'] . '.image'))
                    // $rules['logos.' . $logo['position'] . '.image'] = 'mimes:svg,svgz|max_meg:10';
                $rules['logos.' . $logo['position'] . '.logo'] = 'required';
            }
        }
//$rules['test'] = 'required';
//dd($rules);
        return $rules;
    }

    public function messages()
    {
        $messages = [];
        foreach ($this->logos as $logo) {
            $messages['logos.' . $logo['position'] . '.image.required'] = 'Image has not been provided for icon';
            // $messages['logos.' . $logo['position'] . '.image.mimes']    = 'Image for icon has wrong format, only svg allowed';
            // $messages['logos.' . $logo['position'] . '.image.max_meg']    = 'Image for icon size can\'t be more than 10 megabytes';
            $messages['logos.' . $logo['position'] . '.logo.required']  = 'Subheading required for icon';
        }


        return $messages;
    }
}
