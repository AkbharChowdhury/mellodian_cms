<?php

namespace App\Http\Requests;
// php artisan make:request StoreCreateUserRequest


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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => 'required|min:5|unique:products',
            'description' => 'required|min:5',
            'cost' => 'required|numeric|min:0.5',
            'categories' => 'required',
        ];
    }
}
