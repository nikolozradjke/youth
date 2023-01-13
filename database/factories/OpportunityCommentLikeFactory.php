<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OpportunityComment;
use App\OpportunityCommentLike;
use App\User;
use App\Company;
use Faker\Generator as Faker;

$factory->define(OpportunityCommentLike::class, function (Faker $faker) {
    $commentIDs = OpportunityComment::select('id')->get();
    $userIDs = User::select('id')->get();
    $companyIDs = Company::select('id')->get();

    $user_id = $faker->randomElement($userIDs);
    $type = 'user';
    if ($faker->boolean(30)) {
        $user_id = $faker->randomElement($companyIDs);
        $type = 'company';
    }
    return [
        'opportunity_comment_id' => $faker->randomElement($commentIDs),
        'user_id' => $user_id,
        'user_type' => $type,
        'like' => $faker->boolean(70),
    ];
});
