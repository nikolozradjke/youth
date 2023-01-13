<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Municipality;
use App\Region;
use Faker\Generator as Faker;

$factory->define(Municipality::class, function (Faker $faker) {
    $regionIds = Region::select('id')->get();
    return [
        'name' => $faker->name,
        'region_id' => $faker->randomElement($regionIds),
    ];
});
