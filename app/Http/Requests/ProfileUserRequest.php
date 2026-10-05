<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileUserRequest extends Request
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
            'name' => ['required'],
            'password' => ['required','required_with:password_confirmation', 'confirmed'],
            'avatar' => 'mimes:jpg,jpeg,png,bmp'
        ];
    }
}
