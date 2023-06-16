<?php

namespace Database\Seeders;

use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
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
        $seats = $this->seatData();
        foreach ($seats as $seat)
        {
            Seat::create([
                'seat_type' => $seat['seat_type']

            ]);
        }
    }

    private function seatData()
    {
        return[
            [
                'seat_type' =>'Seats with table'
            ],
            [
                'seat_type' =>'Seats without table'
            ],

        ];
    }
}
