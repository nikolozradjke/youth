<?php

use Illuminate\Database\Seeder;

class OpportunityCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\OpportunityComment::class, 500)->create();
    }
}
