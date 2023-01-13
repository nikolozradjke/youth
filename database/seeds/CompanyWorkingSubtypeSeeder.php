<?php

use Illuminate\Database\Seeder;

class CompanyWorkingSubtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CompanyWorkingSubtype::class, 20)->create();
    }
}
