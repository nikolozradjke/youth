<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OgTag;
use Faker\Generator as Faker;

$factory->define(OgTag::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'route_name' => $faker->title,
        'description' => $faker->text,
        'image' => $faker->imageUrl(400, 300)
    ];
});
