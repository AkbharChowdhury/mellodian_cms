<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Event;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            
//            CategorySeeder::class,
//            ProductSeeder::class,
//            ProductCategoriesSeeder::class,
            AdminSeeder::class,
            SalutationSeeder::class,
            UsersSeeder::class,

            EventSeeder::class,
            SeatSeeder::class,
            TicketSeeder::class




        ]);
    }
}
// php artisan db:seed --class CategorySeeder

