<?php

use App\UserDisability;
use Illuminate\Database\Seeder;

class UserDisabilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserDisability::create(['name' => ['ka'=> 'ფიზიკური შეზღუდვა', 'en' => 'Physycal Dissability'],
                                'disability_id' => 0]);
        UserDisability::create(['name' => ['ka'=> 'სმენის შეზღუდვა', 'en' => 'Hearing Dissability'],
                                'disability_id' => 1]);
        UserDisability::create(['name' => ['ka'=> 'მხედველობის შეზღუდვა', 'en' => 'Visual Dissability'],
                                'disability_id' => 2]);
        UserDisability::create(['name' => ['ka'=> 'მენტალური შეზღუდვა', 'en' => 'Mental Dissability'],
                                'disability_id' => 3]);
        UserDisability::create(['name' => ['ka'=> 'სხვა შეზღუდვა', 'en' => 'Other Dissability'],
                                'disability_id' => 4]);
    }
}
