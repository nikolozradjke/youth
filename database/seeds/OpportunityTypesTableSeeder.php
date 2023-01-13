<?php

use App\OpportunityType;
use Illuminate\Database\Seeder;

class OpportunityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OpportunityType::create([
            'name' => ['ka' => 'ხელოვნება', 'en' => ''],
            'description' => ['ka' => 'ხელოვნება განმარტება', 'en' => '']
        ]);
        OpportunityType::create([
            'name' => ['ka' => 'კულტურა', 'en' => ''],
            'description' => ['ka' => 'კულტურა განმარტება', 'en' => '']
        ]);
        OpportunityType::create([
            'name' => ['ka' => 'განათლება', 'en' => ''],
            'description' => ['ka' => 'განათლება განმარტება', 'en' => '']
        ]);
        OpportunityType::create([
            'name' => ['ka' => 'სხვა', 'en' => ''],
            'description' => ['ka' => 'სხვა განმარტება', 'en' => '']
        ]);
        OpportunityType::create([
            'name' => ['ka' => 'სხვა', 'en' => ''], 'can_be_filled' => true,
            'description' => ['ka' => 'სხვა განმარტება', 'en' => '']
        ]);
    }
}
