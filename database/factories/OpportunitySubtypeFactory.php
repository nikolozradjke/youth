<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OpportunitySubtype;
use App\OpportunityType;
use Faker\Generator as Faker;

$factory->define(OpportunitySubtype::class, function (Faker $faker) {
    $types = OpportunityType::all('id');
    return [
        'name' => $faker->name,
        'opportunity_type_id' => $faker->randomElement($types),
    ];
});
