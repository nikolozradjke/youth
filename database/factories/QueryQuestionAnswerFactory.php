<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Opportunity;
use App\QueryQuestion;
use App\QueryQuestionAnswer;
use App\User;
use Faker\Generator as Faker;

$factory->define(QueryQuestionAnswer::class, function (Faker $faker) {
    $opportunityIDs = Opportunity::select('id')->get();
    $userIDs = User::select('id')->get();
    $questionIDs = QueryQuestion::select('id')->get();

    return [
        'user_id' => $faker->randomElement($userIDs),
        'opportunity_id' => $faker->randomElement($opportunityIDs),
        'question_id' => $faker->randomElement($questionIDs),
        'answer' => rand(1, 5),
    ];
});