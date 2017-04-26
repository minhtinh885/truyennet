<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreateUserInfoRequest extends Request
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
            'fullname' => 'required',
            'stage_name' => 'required|unique:user_infos',
            'description' => 'required',
            'image_url' => 'required',
            'user_id' => 'required',
        ];
    }
}
