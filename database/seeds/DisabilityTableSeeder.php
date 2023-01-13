<?php

use Illuminate\Database\Seeder;
use App\Disability;

class DisabilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Disability::create(['type' => [ 'ka' => 'ადაპტირებულია ფიზიკური შეზღუდვებზე',
                                        'en' => 'Adapted for Physycal Dissabilities'],
                            'description' => ['ka' => 'ფიზიკური შეზღუდვებისთვის აღწერა',
                                             'en' => 'Dummy Physycal Description'],
                            'logo_path' => 'Path/To/Nowhere']);

        Disability::create(['type' => [ 'ka' => 'ადაპტირებულია სმენის შეზღუდვებზე',
                                        'en' => 'Adapted for Hearing Dissabilities'],
                            'description' => ['ka' => 'სმენის შეზღუდვებისთვის აღწერა',
                                             'en' => 'Dummy Hearing Description'],
                            'logo_path' => 'Path/To/Nowhere']);

        Disability::create(['type' => [ 'ka' => 'ადაპტირებულია მხედველობის შეზღუდვებზე',
                                        'en' => 'Adapted for Visual Dissabilities'],
                            'description' => ['ka' => 'მხედველობის შეზღუდვებისთვის აღწერა',
                                             'en' => 'Dummy Visual Description'],
                            'logo_path' => 'Path/To/Nowhere']);

        Disability::create(['type' => [ 'ka' => 'ადაპტირებულია მენტალური შეზღუდვებზე',
                                        'en' => 'Adapted for Mental Dissabilities'],
                            'description' => ['ka' => 'მენტალური შეზღუდვებისთვის აღწერა',
                                             'en' => 'Dummy Mental Description'],
                            'logo_path' => 'Path/To/Nowhere']);

        Disability::create(['type' => [ 'ka' => 'ადაპტირებულია სხვა შეზღუდვებზე',
                                        'en' => 'Adapted for Other Dissabilities'],
                            'description' => ['ka' => 'სხვა შეზღუდვებისთვის აღწერა',
                                             'en' => 'Dummy Other Description'],
                            'logo_path' => 'Path/To/Nowhere']);

    }
}
