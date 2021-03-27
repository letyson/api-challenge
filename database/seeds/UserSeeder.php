<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User example
        User::create(
            [
                'email' => 'test@grainchain.io',
                'password' => Hash::make('12345')
            ]
        );
    }
}
