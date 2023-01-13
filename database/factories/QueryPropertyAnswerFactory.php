<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Opportunity;
use App\QueryOpportunityProperty;
use App\QueryPropertyAnswer;
use App\User;
use Faker\Generator as Faker;

$factory->define(QueryPropertyAnswer::class, function (Faker $faker) {
    $opportunityIDs = Opportunity::select('id')->get();
    $userIDs = User::select('id')->get();
    $propertyIDs = QueryOpportunityProperty::select('id')->get();

    return [
        'user_id' => $faker->randomElement($userIDs),
        'opportunity_id' => $faker->randomElement($opportunityIDs),
        'property_id' => $faker->randomElement($propertyIDs),
        'answer' => rand(0, 1),
    ];
});