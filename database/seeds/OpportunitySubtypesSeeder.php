<?php

use App\Opportunity;
use App\OpportunitySubtype;
use Illuminate\Database\Seeder;

class OpportunitySubtypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $opps = Opportunity::all();
        factory(OpportunitySubtype::class, 15)->create()->each(function ($subtype) use ($opps) {
            $n = rand(2, 5);
            for ($i = 0; $i < $n; $i++) {
                $opps->random()->opportunity_subtypes()->attach($subtype);
            }
        });
    }
}
