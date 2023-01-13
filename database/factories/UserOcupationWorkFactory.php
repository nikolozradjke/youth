<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserOcupationWork;
use Faker\Generator as Faker;

$factory->define(UserOcupationWork::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
