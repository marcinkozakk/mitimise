<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Meeting::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'starts_at' => '2020-05-12 18:00',
        'ends_at' => '2020-05-13 18:00',
        'is_private' => true,
        'is_canceled' => false,

    ];
});
