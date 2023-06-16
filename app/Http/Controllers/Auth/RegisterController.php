<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validatePassword()
    {
        return Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised();
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:200', 'alpha'],
            'lastname' => ['required', 'string', 'max:200', 'alpha'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required'],
            'street_address' => ['required'],
            'city' => ['required'],
            'postcode' => ['required'],
            'house_number' => ['required'],
            'phone' => ['required', 'min:11', 'numeric'],

            'password' => [ 'required', 'string',  $this->validatePassword()],
        ],
        [
            'firstname.required' => ':attribute is required!',
            'lastname.required' => ':attribute is required!',
            'email.required' => ':attribute is required!',
            'password.required' => ':attribute is required!',
            'phone.required' => ':attribute is required!',
            'phone.numeric' => ':attribute must be numeric',
            'phone.min' => 'The :attribute is invalid. The :attribute must start with 0 and be 11 digits long',
            'street_address.required' => ':attribute is required!',
            'city.required' => ':attribute is required!',
            'postcode.required' => ':attribute is required!',
            'house_number.required' => ':attribute is required!',



        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
         return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
    }
}
