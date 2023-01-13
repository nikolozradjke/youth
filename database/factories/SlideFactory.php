<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Slide;
use Faker\Generator as Faker;

$factory->define(Slide::class, function (Faker $faker) {
    $presentations = App\Presentation::all();

    return [
        'title' => $faker->realText(10),
        'text' => $faker->realText(100),
        'content_path' => 'storage/faker_images/image.jpg',
        'presentation_id' => $faker->randomElement($presentations),
    ];
});
