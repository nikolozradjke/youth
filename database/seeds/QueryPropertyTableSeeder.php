<?php

use Illuminate\Database\Seeder;
use App\QueryOpportunityProperty;

class QueryPropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\QueryOpportunityProperty::class, 10)->create();
    }
}
