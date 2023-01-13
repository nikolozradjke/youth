<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Notification;
use App\User;
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

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'title' => $faker->text(20),
        'text' => $faker->text(50),
        'url' => 'https://youthplatform.gov.ge',
        'seen' => $faker->numberBetween(0, 1),
        'user_id' => User::all()->random()->id
    ];
});
