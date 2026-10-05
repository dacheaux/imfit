<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUserRequest extends Request
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
            'type' => ['required'],
            'name' => ['required'],
            'lastname' => ['required'],
            'birth' => ['date'],
            'note' => ['max:2000'],
            'avatar' => 'mimes:jpeg,png,jpg,gif,svg',
            'email' => ['required', 'email', 'unique:users'],
        ];
    }
}
