<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Opportunity;
use App\QueryMessage;
use App\User;
use Faker\Generator as Faker;

$factory->define(QueryMessage::class, function (Faker $faker) {
    $userIDs = User::select('id')->get();

    $opportunities = Opportunity::all();
    if (rand(0, 1)) {
        // create company message
        $opportunity = $faker->randomElement($opportunities);
        return [
            'user_id' => $faker->randomElement($userIDs),
            'company_id' => $opportunity->company_id,
            'opportunity_id' => $opportunity->id,
            'message' => $faker->text,
            'is_private' => rand(0, 1),
            'likes' => 0,
            'dislikes' => 0,
        ];

    } else {
        // create oppurtunity message
        return [
            'user_id' => $faker->randomElement($userIDs),
            'opportunity_id' => $faker->randomElement($opportunities)->id,
            'message' => $faker->text,
            'is_private' => rand(0, 1),
            'likes' => rand(0, 10),
            'dislikes' => rand(0, 5),
        ];

    }
});
