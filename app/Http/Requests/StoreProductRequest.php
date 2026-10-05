<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product_name'             => 'required',
            'product_description'      => 'required',
            'product_quantity'      => 'required|numeric',
            'product_price'     => 'required|numeric',
            'product_image'     => 'mimes:jpg,jpeg,png,bmp',
            'category_id'       => 'required|exists:categories,id',
        ];
    }
}
