<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Disability;
use Faker\Generator as Faker;

$factory->define(Disability::class, function (Faker $faker) {
    return [
        'type' => $faker->text(7),
        'description' => $faker->text(50),
        'logo_path' => 'path/not/specified.jpg'
    ];
});
