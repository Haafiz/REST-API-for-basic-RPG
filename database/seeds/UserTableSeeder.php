<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\User')->create([
            'email' => 'kaasib@gmail.com',
            'password' => app('hash')->make('Haafiz'),
            'remember_token' => str_random(10),
        ]);
    }
}
