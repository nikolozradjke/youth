<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserOccupation;
use Faker\Generator as Faker;

$factory->define(UserOccupation::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
