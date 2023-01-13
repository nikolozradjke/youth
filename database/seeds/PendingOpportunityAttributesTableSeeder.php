<?php

use Illuminate\Database\Seeder;

class PendingOpportunityAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PendingOpportunityAttribute::class, 50)->create();
    }
}
