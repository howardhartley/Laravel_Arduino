<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MakeStationRequest extends Request
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
            'unique'        => 'required|unique:stations|max:255',
            'name'          => 'required|unique:stations|max:255',
            'user_id'       => 'required',
            'is_active'     => 'required',
            'is_private'    => 'required',
            'description'   => 'max:255',
            'location'      => 'required|max:255'
        ];
    }
}
