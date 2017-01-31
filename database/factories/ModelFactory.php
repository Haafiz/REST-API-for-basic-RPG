<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email
    ];
});

$factory->define(App\Models\Character::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'skilled_in' => $faker->sentence,
        'age' => $faker->numberBetween($min=12, $max=80),
        'user_id' => null,
    ];
});

$factory->define(App\Models\Fight::class, function (Faker\Generator $faker) {
    $possibilities = ['won', 'lost', 'draw'];
    $status = $possibilities[rand(0,2)];
    $character = App\Models\Character::first();
    
    return [
        'opponent_id' => $character->id,
        'character_id' => null,
        'status' => $status
    ];
});
