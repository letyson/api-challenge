<?php

use Illuminate\Database\Seeder;

use App\Character;

use Faker\Factory as Faker;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //Create 40 faker Characters
        for ($i = 0; $i < 40; $i++) {
            Character::create(
                [
                    'name' => $faker->firstName(),
                    'status' => $faker->randomElement($array = array('Alive', 'Dead', 'Unknown')),
                    'species' => $faker->randomElement($array = array('Human', 'Animal', 'Alien')),
                    'type' => '',
                    'gender' => $faker->randomElement($array = array('female', 'male', 'genderless', 'unknown')),

                    'origin' => json_decode('{"name":"Springfield","url":"https://en.wikipedia.org/wiki/Springfield_(The_Simpsons)"}'),
                    'location' => json_decode('{"name":"Bikini Bottom","url":"https://spongebob.fandom.com/wiki/Bikini_Bottom"}'),

                    'image' => $faker->imageUrl($width = 640, $height = 480),
                    'episode' => json_encode([$faker->url])
                ]
            );
        }
    }
}
