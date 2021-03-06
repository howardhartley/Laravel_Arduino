<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MakeUserRequest extends Request
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
        return [
            'name'      => 'required|max:255',
            'surname'   => 'required|max:255',
            'email'     => 'required|email|unique:users|max:255',
            'password'  => 'required|min:6|max:255',
            'role_id'   => 'required'
        ];
    }
}
