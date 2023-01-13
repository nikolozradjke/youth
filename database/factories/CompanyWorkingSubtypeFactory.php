<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CompanyWorkingSubtype;
use App\CompanyWorkingType;
use Faker\Generator as Faker;

$factory->define(CompanyWorkingSubtype::class, function (Faker $faker) {
    $types = CompanyWorkingType::all('id');
    return [
        'name' => $faker->name,
        'company_working_type_id' => $faker->randomElement($types),
    ];
});
