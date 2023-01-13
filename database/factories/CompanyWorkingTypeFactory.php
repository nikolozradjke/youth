<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CompanyWorkingType;
use Faker\Generator as Faker;

$factory->define(CompanyWorkingType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
    ];
});
