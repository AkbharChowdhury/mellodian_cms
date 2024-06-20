<?php

namespace Database\Seeders;

use App\Enums\AdultSupervision;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insert();
    }

    private function insert()
    {
        $events = $this->productCategories();

        foreach ($events as $event) {
            Event::create(
                [
                    'event_title' => $event['event_title'],
                    'event_description' => $event['event_description'],
                    'event_date' => $event['event_date'],
                    'start_time' => $event['start_time'],
                    'end_time' => $event['end_time'],
                    'adult_supervision' => $event['adult_supervision']


                ]
            );
        }
    }


    private function productCategories()
    {

        return [

            [
                'event_title' => 'Colossus',
                'event_description' => "The world’s first ten-loop roller coaster\r\nExperience TEN exhilarating inversions, including a vertical loop, cobra roll, double corkscrew and the UK’s only quadruple barrel roll! Colossus proudly stands amongst the top ten roller coasters with the most inversions, worldwide!\r\nAt 98 ft in the air, the iconic steel track stands like the Colossus of Rhodes - a powerful wonder of the theme park world! Fly high and low through Thorpe Park’s Lost City, close enough to wave to visitors on the path, before you dive into an underground trench. Brace yourself: there are surprises hidden around every curved corner on Colossus!",
                'event_date' => '2024-11-27',
                'start_time' => '14:00:00',
                'end_time' => '17:00:00',
                'adult_supervision' => AdultSupervision::Yes()


            ],

            [
                'event_title' => 'Nemesis Inferno',
                'event_description' => "Burst through the fiery pit at the heart of a steaming volcano. Nemesis Inferno takes an iconic thrill ride and turns up the heat… With your legs hanging freely below you on this inverted coaster, try not to let your feet get burnt!",
                'event_date' => '2024-11-27',
                'start_time' => '15:00:00',
                'end_time' => '19:00:00',
                'adult_supervision' => AdultSupervision::Yes()


            ],

//

        ];
    }
}
