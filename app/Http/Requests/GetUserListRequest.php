<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GetUserListRequest extends Request
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
        if (! $this->has('sortBy')){
            $input['sortBy'] = \Session::has('usersSortBy') ? \Session::get('usersSortBy') : 'name';
            $this->merge($input);
        }
        else{
            \Session::put('usersSortBy',$this->get('sortBy'));
        }
        if (! $this->has('order')){
            $input['order'] = \Session::has('usersOrder') ? \Session::get('usersOrder') : 'desc';
            $this->merge($input);
        }
        else{
            \Session::put('usersOrder',$this->get('order'));
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
            //
        ];
    }
}
