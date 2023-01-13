<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\QueryOpportunityProperty;
use Faker\Generator as Faker;

$factory->define(QueryOpportunityProperty::class, function (Faker $faker) {
    return [
        'text' => $faker->word
    ];
});
