<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTermsRequest extends FormRequest
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
            'slots'             => 'required',
            'note'             => 'required',
            'workout_id'         => 'required|exists:workouts,id',
            'start_datetime'    => 'required|date',
            'end_datetime'    => 'date'
        ];
    }
}
