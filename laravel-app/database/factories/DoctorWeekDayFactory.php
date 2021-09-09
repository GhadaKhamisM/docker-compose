<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DoctorWeekDay;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(DoctorWeekDay::class, function (Faker $faker) {
    return [
        'week_day_id' => $faker->numberBetween(1, 7),
        'start_hour' => $faker->time('H:i'),
        'to_hour' => $faker->time('H:i'),
    ];
});
