<?php

use Illuminate\Database\Seeder;
use App\Location;
use Faker\Factory as Faker;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Location::create(
            [
                'name' => 'Springfield',
                'type' => 'City',
                'dimension' => 'huge',
                'residents' => '',
                'url' => 'https://en.wikipedia.org/wiki/Springfield_(The_Simpsons)'
            ]
        );

        Location::create(
            [
                'name' => 'Bikini Bottom',
                'type' => 'Undersea',
                'dimension' => 'oceanic',
                'residents' => '',
                'url' => 'https://spongebob.fandom.com/wiki/Bikini_Bottom'
            ]
        );

        $faker = Faker::create();
        //Create 10 faker Locations
        for ($i = 0; $i < 10; $i++) {
            Location::create(
                [
                    'name' => $faker->city(),
                    'type' => $faker->randomElement($array = array('City', 'Planet', 'Space station')),
                    'dimension' => 'unknown',
                    'residents' => json_encode([$faker->url]),
                    'url' => $faker->url
                ]
            );
        }
    }
}
