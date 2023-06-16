<?php

namespace Database\Seeders;

use App\Models\CustomHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'salutation_id' => 2,
            'firstname' => 'Lorraine',
            'lastname' =>'Webb',
            'email' => 'LorraineEWebb@rhyta.com',
            'password' => Hash::make('password' ),// CustomHelper::getPasswordSalt()),
            'phone' => '06129200524',
            'passport_image' => NULL,
            'house_number' => '3816',
            'street' => 'Rocket Drive',
            'city' => 'Minneapolis',
            'postcode' => 'MN 55410',

        ]);


    }
}
