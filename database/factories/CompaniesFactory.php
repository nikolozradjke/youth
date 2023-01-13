<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\NumberOfEmployees;
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

$factory->define(Company::class, function (Faker $faker) {
    $numberIds = NumberOfEmployees::select('id')->get();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        //'email_verified_at' => now(),
        'phone' => $faker->phoneNumber,
        'phone2' => $faker->numberBetween(0, 1) ? $faker->phoneNumber : null,
        'registration_id' => $faker->unique()->numberBetween(100000000, 999999999) . '',
        'number_of_employees_id' => $faker->randomElement($numberIds),
        'address' => $faker->address,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'description1' => $faker->realText(300),
        'fb_page' => 'http://facebook.com',
        'linkedin_page' => 'http://linkedin.com',
        'web_page' => 'http://youth.test',
        'document' => $faker->text(15) . 'pdf',
        'image' => 'storage/faker_images/image.jpg',
        'approved' => $faker->numberBetween(0, 1)
    ];
});
