<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\StaticDataMainPage;
use App\StaticDataUserRegistration;
use App\StaticDataCompanyRegistration;
use App\StaticDataAboutUs;
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

$factory->define(StaticDataMainPage::class, function (Faker $faker) {
    return [
        'user_section_title' => $faker->text(20),
        'user_section_subtitle' => $faker->text(20),
        'user_section_text' => $faker->text(200),
    ];
});

$factory->define(StaticDataUserRegistration::class, function (Faker $faker) {
    return [
        'confidentiality_title' => $faker->text(20),
        'confidentiality_text' => $faker->text(200),
        'terms_title' => $faker->text(20),
        'terms_text' => $faker->text(200),
    ];
});

$factory->define(StaticDataCompanyRegistration::class, function (Faker $faker) {
    return [
        'confidentiality_title' => $faker->text(20),
        'confidentiality_text' => $faker->text(200),
        'terms_title' => $faker->text(20),
        'terms_text' => $faker->text(200),
    ];
});

$factory->define(StaticDataAboutUs::class, function (Faker $faker) {
    return [
        'about_us_title' => $faker->text(20),
        'about_us_subtitle' => $faker->text(20),
        'about_us_text' => $faker->text(200)
    ];
});
