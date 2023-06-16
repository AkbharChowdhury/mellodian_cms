<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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

            'firstname' => ['required', 'string', 'max:100', 'alpha'],
            'lastname' => ['required', 'string', 'max:100', 'alpha'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:admins'],
            'password' => ['required'],

        ];

    }
}
