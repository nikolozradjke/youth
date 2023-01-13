<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\QueryUnattendedQuestionOption;
use Faker\Generator as Faker;

$factory->define(QueryUnattendedQuestionOption::class, function (Faker $faker) {
    return [
        'text' => $faker->word
    ];
});
