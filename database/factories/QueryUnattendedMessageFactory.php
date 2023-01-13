<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Opportunity;
use App\QueryUnattendedMessage;
use App\User;
use Faker\Generator as Faker;

$factory->define(QueryUnattendedMessage::class, function (Faker $faker) {
    $opportunityIDs = Opportunity::select('id')->get();
    $userIDs = User::select('id')->get();

    return [
        'user_id' => $faker->randomElement($userIDs),
        'opportunity_id' => $faker->randomElement($opportunityIDs),
        'message' => $faker->text,
        'is_private' => rand(0, 1),
    ];
});