<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('CharacterSeeder');
        $this->call('LocationSeeder');

        //We only need one register in the table (user example)
        User::truncate();
        $this->call('UserSeeder');
    }
}
