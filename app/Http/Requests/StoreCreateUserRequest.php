<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;


class StoreCreateUserRequest extends FormRequest
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
            'salutation_id' => ['required'],
            'firstname' => ['required', 'string', 'max:200', 'alpha'],
            'lastname' => ['required', 'string', 'max:200', 'alpha'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required'],
             'street_address' => ['required'],
             'city' => ['required'],
             'postcode' => ['required'],
             'house_number' => ['required'],
             'phone' => ['required', 'starts_with:0', 'min:11', 'numeric']
//                'agree' => ['required']
        ];
        
    }

    private function validatePassword()
    {
        return Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised();
    }
}
