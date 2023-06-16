<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Salutation;


class SalutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insert();
    }
    private function insert()
    {
        $titles = ['Mr', 'Mrs', 'Miss'];
        foreach ($titles as $title)
        {
            Salutation::create(['title' => $title]);
        }
    }
}
