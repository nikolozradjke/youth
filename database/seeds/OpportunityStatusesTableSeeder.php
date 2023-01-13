<?php

use Illuminate\Database\Seeder;

class OpportunityStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\OpportunityStatus::class, 50)->create();
    }
}
