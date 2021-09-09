<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Doctor;
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

$factory->define(Doctor::class, function (Faker $faker) {
    return [
        'name_arabic' => $faker->name(),
        'name_english' => $faker->name(),
        'mobile' => $faker->numerify('###########'),
        'password' => 'secret', // password,
        'photo' => $faker->image('public/uploads/doctors',640,480, null, true),
        'time_slot' => $faker->numberBetween(0, 60),
        'email' => $faker->email(),
    ];
});
