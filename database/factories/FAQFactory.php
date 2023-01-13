<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\FAQ;
use App\Opportunity;
use Faker\Generator as Faker;

$factory->define(FAQ::class, function (Faker $faker) {
    $opportunityIDs = Opportunity::select('id')->get();
    return [
        'question' => $faker->text(),
        'answer' => $faker->text(),
        'opportunity_id' => $faker->randomElement($opportunityIDs),
    ];
});
