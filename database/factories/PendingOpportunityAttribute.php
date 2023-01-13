<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\PendingOpportunityAttribute;
use App\Opportunity;
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

$factory->define(PendingOpportunityAttribute::class, function (Faker $faker) {
    $opportunities = Opportunity::select('id')->get();
    $value = null;
    $field = $faker->randomElement(['name_ka', 'name_en', 'date_ka', 'date_en', 'start_date', 'end_date', 'schedule_date', 'opportunity_status_id', 'image']);
    if($field == 'start_date' || $field == 'end_date' || $field == 'schedule_date') {
        $value = $faker->date;
    }
    elseif($field == 'image') {
        $value = 'storage/faker_images/image.jpg';
    }
    else {
        $value = $faker->text(20);
    }
    return [
        'opportunity_id' => $faker->randomElement($opportunities),
        'field' => $field,
        'value' => $value
    ];
});
