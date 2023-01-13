<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserOcupationStudy;
use Faker\Generator as Faker;

$factory->define(UserOcupationStudy::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
