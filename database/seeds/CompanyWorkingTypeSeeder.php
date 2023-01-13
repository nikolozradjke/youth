<?php

use Illuminate\Database\Seeder;

class CompanyWorkingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CompanyWorkingType::class, 5)->create();
        App\CompanyWorkingType::create([
            'name' => ['ka' => 'სხვა', 'en' => 'Other'],
            'description' => ['ka' => 'სხვა', 'en' => 'Other'],
            'can_be_filled' => true
        ]);
    }
}
