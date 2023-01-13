<?php

use Illuminate\Database\Seeder;

class StaticDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\StaticDataMainPage::class, 1)->create();
        factory(App\StaticDataUserRegistration::class, 1)->create();
        factory(App\StaticDataCompanyRegistration::class, 1)->create();
        factory(App\StaticDataAboutUs::class, 1)->create();
    }
}
