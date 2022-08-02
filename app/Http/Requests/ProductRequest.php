<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:80',
            'price' => 'required|numeric|min:100|max:99999999',
            'image' => 'required',
            'status_product' => 'required|mimes:jpg'
        ];
    }
}
