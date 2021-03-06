<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ChapterCreateRequest extends Request
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
            'title' => 'required',
            'ordinal' => 'required|numeric',
            'content' => 'required',
            'published_at' => 'required',
            'book_id' => 'required',
        ];
    }
}
