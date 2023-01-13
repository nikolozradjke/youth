<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Opportunity;
use App\QueryUnattendedQuestion;
use App\QueryUnattendedQuestionAnswer;
use App\QueryUnattendedQuestionOption;
use App\User;
use Faker\Generator as Faker;

$factory->define(QueryUnattendedQuestionAnswer::class, function (Faker $faker) {
    $opportunityIDs = Opportunity::select('id')->get();
    $userIDs = User::select('id')->get();
    $questionIDs = QueryUnattendedQuestion::select('id')->get();
    $optionIDs = QueryUnattendedQuestionOption::select('id')->get();

    return [
        'user_id' => $faker->randomElement($userIDs),
        'opportunity_id' => $faker->randomElement($opportunityIDs),
        'question_id' => $faker->randomElement($questionIDs),
        'option_id' => $faker->randomElement($optionIDs),
        'text' => $faker->text,
    ];
});