<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Character;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserTableSeeder');
        $this->call('CharacterTableSeeder');
    }
}
