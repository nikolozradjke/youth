<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\QueryQuestion;
use Faker\Generator as Faker;

$factory->define(QueryQuestion::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence,
        'details' => $faker->text,
    ];
});
