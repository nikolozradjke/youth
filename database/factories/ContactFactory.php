<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Contact;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'fb_link' => 'http://facebook.com',
        'twitter_link' => 'http://twitter.com',
        'insta_link' => 'http://facebook.com',
        'latitude' => '41.7151',
        'longitude' => '44.8271'
    ];
});
