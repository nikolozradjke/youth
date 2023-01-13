<?php

use App\OgTag;
use Illuminate\Database\Seeder;

class OgTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $views = ['home', 'opportunities', 'company-profile', 'main',
            'about', 'contact', 'search', 'events',
            'login', 'logout', 'user-registration', 'org-registration',
            'profile', 'reset-email-form', 'reset-form'];

        foreach ($views as $view) {
            factory(OgTag::class)->create([
                'title' => $view,
                'route_name' => $view,
            ]);
        }
    }
}
