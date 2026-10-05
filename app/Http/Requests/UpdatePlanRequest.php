<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'workout_id'  => 'required|exists:workouts,id',
            'name'  => 'required',
            'workouts_number'  => 'required|numeric',
            'plan_duration'  => 'required|numeric',
            'price'  => 'required|numeric',
        ];
    }
}
