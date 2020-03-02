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
            'product.name'  => 'required|string|max:255',
            'product.price' => 'required|numeric|min:0|max:99999999.99',
            'product.area'  => 'required|numeric|min:0|max:99999999.99',
            'product.color' => 'required|string|max:255',

            'property.*.name'  => 'required|string|max:255|distinct',
            'property.*.value' => 'required|string|max:255',
        ];
    }
}
