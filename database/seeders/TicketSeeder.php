<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $tickets = $this->ticketData();
        foreach ($tickets as $ticket)
        {
            Ticket::create([
                'type' =>$ticket['type'],
                'price' =>$ticket['price'],

            ]);
        }
    }

    private function ticketData()
    {
        return[
            [
                'type' =>'Adult',
                'price' =>20,
            ],
            [
                'type' =>'Child',
                'price' =>10,
            ],

        ];
    }
}
