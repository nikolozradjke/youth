<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Opportunity;
use App\OpportunityComment;
use App\User;
use Faker\Generator as Faker;

$factory->define(OpportunityComment::class, function (Faker $faker) {
    $opportunityIDs = Opportunity::select('id')->get();
    $userIDs = User::select('id')->get();
    return [
        'text' => $faker->text,
        'user_id' => $faker->randomElement($userIDs),
        'opportunity_id' => $faker->randomElement($opportunityIDs),
    ];
});
