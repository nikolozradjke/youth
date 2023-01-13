<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Opportunity;
use App\Company;
use App\OpportunityStatus;
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

$factory->define(Opportunity::class, function (Faker $faker) {
    $statusIds = OpportunityStatus::select('id')->get();
    $companyIds = Company::select('id')->get();
    $unixTimestap = '1461067200';
    return [
        'name' => $faker->text(20),
        'description' => $faker->realText(100),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'start_date' => $faker->dateTimeBetween('-1 month', '+0 days'),
        'end_date' => $faker->dateTimeBetween('+0 days', '+1 month'),
        'schedule_date' => $faker->dateTimeBetween('-1 month', '-10 days'),
        'company_id' => $faker->randomElement($companyIds),
        'image' => 'storage/faker_images/image.jpg',
        'order' => $faker->unique()->randomNumber,
        'fb_page' => 'http://facebook.com',
        'linkedin_page' => 'http://linkedin.com',
        'web_page' => 'http://youth.test',
        'latitude' => '41.7151',
        'longitude' => '44.8271'
    ];
});
